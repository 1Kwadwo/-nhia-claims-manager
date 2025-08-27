#!/bin/bash

# Set default values for environment variables if not set
export APP_ENV=${APP_ENV:-production}
export APP_DEBUG=${APP_DEBUG:-false}
export DB_CONNECTION=${DB_CONNECTION:-sqlite}
export DB_DATABASE=${DB_DATABASE:-/var/www/database/database.sqlite}
export CACHE_DRIVER=${CACHE_DRIVER:-file}
export SESSION_DRIVER=${SESSION_DRIVER:-file}
export QUEUE_CONNECTION=${QUEUE_CONNECTION:-sync}
export LOG_CHANNEL=${LOG_CHANNEL:-stack}

# Generate application key if not set or empty
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ] || [ "$APP_KEY" = "base64:" ]; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# Install Node.js dependencies and build Vite assets
echo "Installing Node.js dependencies..."
npm install --production=false

echo "Building Vite assets..."
npm run build

# Verify the manifest file was created
if [ ! -f "public/build/manifest.json" ]; then
    echo "ERROR: Vite manifest not found after build!"
    echo "Creating a fallback manifest..."
    mkdir -p public/build
    echo '{"resources/css/app.css":{"file":"app.css","src":"resources/css/app.css","isEntry":true},"resources/js/app.js":{"file":"app.js","src":"resources/js/app.js","isEntry":true}}' > public/build/manifest.json
fi

# Clear all caches
echo "Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Seed database if needed
echo "Seeding database..."
php artisan db:seed --force

# Start Laravel server
echo "Starting Laravel server..."
php artisan serve --host=0.0.0.0 --port=8000
