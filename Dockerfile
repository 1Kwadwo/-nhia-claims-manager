FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    sqlite3 \
    libsqlite3-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd pdo_sqlite

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www-data:www-data . /var/www

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Generate application key
RUN php artisan key:generate

# Create SQLite database
RUN touch database/database.sqlite

# Run migrations and seed
RUN php artisan migrate --seed --force

# Change ownership of our applications
RUN chown -R www-data:www-data /var/www

# Expose port 8000
EXPOSE 8000

# Start Laravel development server
CMD php artisan serve --host=0.0.0.0 --port=8000
