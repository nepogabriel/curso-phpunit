# Dockerfile
FROM php:8.4-cli

# Instala extensões necessárias
RUN apt-get update \
    && apt-get install -y unzip git \
    && docker-php-ext-install pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho
WORKDIR /app

# Executa dump-autoload do Composer
RUN composer dump-autoload

# Comando padrão ao iniciar o container
CMD ["php", "-a"]
