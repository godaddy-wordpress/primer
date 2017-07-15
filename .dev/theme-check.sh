#!/bin/bash

set -e

DB_NAME=wordpress
DB_USER=root
DB_PASS=''
DB_HOST=localhost

if install_wp && install_db; then
	echo "WordPress installed"
fi

cd ${WP_CORE_DIR}/src

php /tmp/wp-cli.phar config create \
	--dbname=${DB_NAME} \
	--dbuser=${DB_USER} \
	--dbpass=${DB_PASS} \
	--dbhost=${DB_HOST}

export INSTALL_PATH=${WP_CORE_DIR}/src/wp-content/themes/${WP_THEME}
mkdir -p ${INSTALL_PATH}
rsync -av --exclude-from ${TRAVIS_BUILD_DIR}/.distignore --delete ${TRAVIS_BUILD_DIR}/ ${INSTALL_PATH}/

php /tmp/wp-cli.phar package install anhskohbo/wp-cli-themecheck
php /tmp/wp-cli.phar plugin install theme-check --activate
php /tmp/wp-cli.phar themecheck --theme=${WP_THEME} --no-interactive
