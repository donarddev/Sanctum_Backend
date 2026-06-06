#!/bin/sh
set -e

echo "Starting Laravel deployment setup..."

php artisan config:clear
php artisan route:clear
php artisan view:clear

echo "Running database migrations and seeders..."
php artisan migrate --seed --force

echo "Starting Apache..."
apache2-foreground