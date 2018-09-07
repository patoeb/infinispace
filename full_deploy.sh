#!/bin/bash
clear
php bin/magento setup:upgrade --keep-generated
rm -rf var/di var/generation/ var/page_cache/ var/report/ var/view_preprocessed var/cache/ var/tmp/
php bin/magento setup:di:compile
rm -rf pub/static/*
php bin/magento setup:static-content:deploy -f
rm -rf var/di var/generation/
php bin/magento cache:flush
chmod -R 777 pub/static pub/media var/
git checkout *.htaccess*
git checkout bin/magento