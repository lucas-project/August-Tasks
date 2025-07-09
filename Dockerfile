FROM wordpress:latest

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files
COPY composer.json ./

# Install dependencies (but don't run scripts or autoloader)
RUN composer install --no-scripts --no-autoloader

# Copy the rest of the application
COPY . ./

# Generate autoloader
RUN composer dump-autoload --optimize 