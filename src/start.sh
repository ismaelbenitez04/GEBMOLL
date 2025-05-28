#!/bin/bash

# Asegurarse de que las carpetas necesarias existen
mkdir -p storage/framework/{sessions,views,cache}

# Dar permisos
chmod -R 775 storage bootstrap/cache

# Limpiar cachés
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Lanzar Laravel
php artisan serve --host=0.0.0.0 --port=8000
