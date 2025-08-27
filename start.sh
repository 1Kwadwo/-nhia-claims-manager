#!/bin/bash

# Generate application key if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate
fi

# Run migrations
php artisan migrate --force

# Seed database if needed
php artisan db:seed --force

# Start Laravel server
php artisan serve --host=0.0.0.0 --port=8000
