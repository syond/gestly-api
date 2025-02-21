#!/bin/bash
# startup.sh

# Define permissions for storage folder
chmod -R 775 /usr/share/nginx/html/storage
chown -R www-data:www-data /usr/share/nginx/html/storage

# Laravel cache clear (optional)
#php /usr/share/nginx/html/artisan cache:clear
#php /usr/share/nginx/html/artisan config:clear
#php /usr/share/nginx/html/artisan view:clear
#php /usr/share/nginx/html/artisan route:clear

# Mantém o container rodando (necessário para o PHP-FPM)
exec "$@"