#!/bin/bash

set -e

DB_USER=root
DB_PASS=''

if install_wp && install_db; then
	echo "WordPress is now installed"
fi

INSTALL_PATH=${WP_CORE_DIR}/src/wp-content/themes/${WP_THEME}

mkdir -p ${INSTALL_PATH}
rsync -av --exclude-from ${TRAVIS_BUILD_DIR}/.distignore --delete ${TRAVIS_BUILD_DIR}/ ${INSTALL_PATH}/
cd ${INSTALL_PATH}

php /tmp/wp-cli.phar package install anhskohbo/wp-cli-themecheck
php /tmp/wp-cli.phar plugin install theme-check --activate
php /tmp/wp-cli.phar themecheck --theme=${WP_THEME} --no-interactive
