#!/usr/bin/env bash

source /app/vagrant/provision/common.sh

#== Provision script ==

info "Provision-script user: `whoami`"

info "Restart web-stack"
localedef ru_RU.UTF-8 -i ru_RU -f UTF-8
service php7.3-fpm restart
service nginx restart
service postgresql restart
