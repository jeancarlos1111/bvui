FROM php:8.5-cli-alpine

# Instalar dependencias del sistema requeridas
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    nodejs \
    npm \
    linux-headers \
    bash \
    supervisor \
    $PHPIZE_DEPS

# Instalar extensiones de PHP necesarias para Laravel
RUN docker-php-ext-install pdo_mysql pcntl bcmath gd zip \
    && pecl install redis \
    && docker-php-ext-enable redis

# Obtener la última versión de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar el directorio de trabajo
WORKDIR /var/www/html

# Exponer el puerto para php artisan serve y Vite
EXPOSE 8000
EXPOSE 5173

# Copiar la configuración de supervisor
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Comando por defecto usando Supervisor para manejar múltiples procesos (serve y colas)
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
