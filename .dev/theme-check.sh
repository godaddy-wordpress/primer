#!/bin/bash

set -e

if [ ${TRAVIS_PHP_VERSION:0:3} != "5.6" ] && [ ${TRAVIS_PHP_VERSION:0:2} != "7." ];
	return
fi

mkdir -p ${INSTALL_PATH}

rsync -av --exclude-from ${PROJECT_DIR}/.distignore --delete ${PROJECT_DIR}/ ${INSTALL_PATH}/

php /tmp/wp-cli.phar package install anhskohbo/wp-cli-themecheck; fi
php /tmp/wp-cli.phar plugin install theme-check --activate --path=${WP_CORE_DIR}/src; fi
php /tmp/wp-cli.phar theme activate primer --path=${WP_CORE_DIR}/src; fi
php /tmp/wp-cli.phar themecheck --theme=primer --no-interactive --path=${WP_CORE_DIR}/src; fi
