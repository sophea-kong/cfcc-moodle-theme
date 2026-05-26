FROM php:8.1-apache

# Install PHP extensions required by Moodle
# Uses a robust retry strategy to handle network issues
RUN apt-get clean && rm -rf /var/lib/apt/lists/* && \
    for i in 1 2 3; do \
    apt-get update --fix-missing && \
    apt-get install -y --no-install-recommends \
    git \
    curl \
    libpng-dev \
    libzip-dev \
    libicu-dev \
    libxml2-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpq-dev \
    libonig-dev \
    ghostscript \
    clamav \
    unzip && \
    break || sleep 10; \
    done && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) \
    gd \
    zip \
    intl \
    mysqli \
    pdo \
    pdo_mysql \
    soap \
    opcache \
    mbstring && \
    a2enmod rewrite && \
    rm -rf /var/lib/apt/lists/*

# PHP configuration for Moodle
RUN { \
    echo 'memory_limit = 512M'; \
    echo 'upload_max_filesize = 100M'; \
    echo 'post_max_size = 100M'; \
    echo 'max_execution_time = 300'; \
    echo 'max_input_vars = 5000'; \
    } > /usr/local/etc/php/conf.d/moodle.ini

# Download Moodle
WORKDIR /var/www/html
RUN git clone --depth=1 --branch=MOODLE_403_STABLE https://github.com/moodle/moodle.git /var/www/html \
    && chown -R www-data:www-data /var/www/html

# Create directory for Moodle data
RUN mkdir -p /var/www/moodledata && chown -R www-data:www-data /var/www/moodledata

# Install MySQL client for the installation script
RUN for i in 1 2 3; do \
    apt-get update --fix-missing && \
    apt-get install -y --no-install-recommends default-mysql-client && \
    break || sleep 10; \
    done && \
    rm -rf /var/lib/apt/lists/*

# Download and install CodeRunner plugin from GitHub (fallback if local volume not used)
RUN cd /var/www/html/question/type && \
    git clone --depth=1 --branch=v5.9.2 https://github.com/trampgeek/moodle-qtype_coderunner.git coderunner && \
    chown -R www-data:www-data /var/www/html/question/type/coderunner

# Download and install adaptive_adapted_for_coderunner behaviour
RUN cd /var/www/html/question/behaviour && \
    git clone --depth=1 --branch=master https://github.com/trampgeek/moodle-qbehaviour_adaptive_adapted_for_coderunner.git adaptive_adapted_for_coderunner && \
    chown -R www-data:www-data /var/www/html/question/behaviour/adaptive_adapted_for_coderunner

# Copy entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
