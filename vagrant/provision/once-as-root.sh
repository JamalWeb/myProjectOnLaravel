#!/usr/bin/env bash

source /app/vagrant/provision/common.sh

#== Import script args ==

timezone=$(echo "$1")

#== Provision script ==

info "Provision-script user: `whoami`"

export DEBIAN_FRONTEND=noninteractive

info "Configure timezone"
timedatectl set-timezone ${timezone} --no-ask-password

info "Add PHp 7.3 repository"
add-apt-repository ppa:ondrej/php -y

info "Add PostgreSQL sources"
wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | sudo apt-key add -
sh -c 'echo "deb http://apt.postgresql.org/pub/repos/apt/ $(lsb_release -sc)-pgdg main" > /etc/apt/sources.list.d/PostgreSQL.list'

info "Update OS software"
apt-get update
apt-get upgrade -y

info "Configure locales"
apt-get install -y locales
localedef ru_RU.UTF-8 -i ru_RU -f UTF-8

info "Install additional software"
apt-get install -y php7.3-curl php7.3-cli php7.3-intl php7.3-pgsql php7.3-gd php7.3-fpm php7.3-mbstring php7.3-xml php7.3-zip php7.3-soap php7.3-zmq php7.3-bcmath unzip software-properties-common sshpass htop php.xdebug
apt-get install -y postgresql-10 postgresql-contrib-10
apt-get install -y nginx

# info "Configure PostgreSQL"
info "Configure PostgreSQL"
sudo -u postgres psql -c "CREATE USER vordev WITH SUPERUSER CREATEDB ENCRYPTED PASSWORD 'vorDev996'"
sudo -u postgres psql -c "CREATE DATABASE project"
sudo /etc/init.d/postgresql restart
echo "Done!"

info "Configure PHP-FPM"
sed -i 's/user = www-data/user = vagrant/g' /etc/php/7.3/fpm/pool.d/www.conf
sed -i 's/group = www-data/group = vagrant/g' /etc/php/7.3/fpm/pool.d/www.conf
sed -i 's/owner = www-data/owner = vagrant/g' /etc/php/7.3/fpm/pool.d/www.conf
cat << EOF > /etc/php/7.3/mods-available/xdebug.ini
zend_extension=xdebug.so
xdebug.remote_enable=1
xdebug.remote_connect_back=1
xdebug.remote_port=9000
xdebug.remote_autostart=1
EOF
echo "...successful with php7.3-fpm service restart...";
echo "Done!"

info "Configure NGINX"
sed -i 's/user www-data/user vagrant/g' /etc/nginx/nginx.conf
echo "Done!"

info "Enabling site configuration"
ln -s /app/vagrant/nginx/app.conf /etc/nginx/sites-enabled/app.conf
echo "Done!"

service nginx restart;
echo "...successful with nginx service restart...";

info "Install composer"
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
