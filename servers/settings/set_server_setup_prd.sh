#!/usr/bin/env bash

# Подключил функции хелперы
source common.sh

# Какой пользователь запустил скрипт
info "Provision-script user: $(whoami)"

# Многие пакеты при установке запрашивают данные для конфигурации.
# Примерами таких пакетов могут служить:
# mysql — при установке спрашивает пароль пользователя root;
# libnss-ldap — спрашивает данные на доступ к LDAP-серверу.
# Для того, чтобы инсталлировать пакет в Ubuntu «без лишних вопросов»,
# надо установить переменную окружения DEBIAN_FRONTEND в значение noninteractive.
export DEBIAN_FRONTEND=noninteractive

# Установка временой зоны
sudo timedatectl set-timezone Europe/Moscow

# Обновляем систему Ubuntu
update

sudo apt install mc

# PPA-репозиторий Ondřej Surý для установки версии PHP 7.3
apt install software-properties-common python-software-properties

# После завершения установки добавьте Ondřej PPA:
LC_ALL=C.UTF-8 add-apt-repository ppa:ondrej/php

info "Add PostgreSQL sources"
wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | sudo apt-key add -
sh -c 'echo "deb http://apt.postgresql.org/pub/repos/apt/ $(lsb_release -sc)-pgdg main" > /etc/apt/sources.list.d/PostgreSQL.list'

# Обновляем наши источники
update

info "Configure locales"
apt install -y locales
localedef ru_RU.UTF-8 -i ru_RU -f UTF-8

info "Install additional software"
apt install -y php7.3-curl php7.3-cli php7.3-intl php7.3-pgsql php7.3-gd php7.3-fpm php7.3-mbstring php7.3-xml php7.3-zip php7.3-soap php7.3-zmq php7.3-bcmath unzip nginx software-properties-common sshpass htop
apt install -y postgresql-10 postgresql-contrib-10

info "Configure PostgreSQL"
sudo -u postgres psql -c "CREATE USER wacggdfing WITH SUPERUSER CREATEDB ENCRYPTED PASSWORD 'IzhX9wHdVY~@uc*m'"
sudo -u postgres psql -c "CREATE DATABASE db_mappa"
sudo /etc/init.d/postgresql restart
echo "Done!"

info "Install curl"
sudo apt install curl

info "Install composer"
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

info "Restart web-stack"
localedef ru_RU.UTF-8 -i ru_RU -f UTF-8
service php7.3-fpm restart
service nginx restart
service postgresql restart
service cron restart

info "Configure composer"
info "GitHub Token:"
read github_token
composer config --global github-oauth.github.com $github_token
echo "Done!"

info "Install project dependencies"
cd /app
composer --no-progress --prefer-dist install

info "Init project"
./init --env=Production --overwrite=y
