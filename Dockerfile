FROM php:8.2-fpm

# Տեղադրում ենք համակարգային փաթեթները և անհրաժեշտ գրադարանները (ներառյալ zip, bz2, թեթև zip-երի համար)
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    nginx

# Մաքրում ենք քեշը
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Տեղադրում ենք PHP ընդլայնումները (ավելացված է zip-ը, որը Composer-ին շատ է պետք)
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Տեղադրում ենք Composer-ը
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Սահմանում ենք աշխատանքային թղթապանակը
WORKDIR /var/www

# Պատճենում ենք նախագծի ֆայլերը
COPY . /var/www

# Տեղադրում ենք կախվածությունները՝ անտեսելով հարթակի սահմանափակումները (--ignore-platform-reqs)
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Իրավունքները տալիս ենք Laravel-ին
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Nginx-ի կարգավորում
RUN echo "server { \n\
    listen 80; \n\
    index index.php index.html; \n\
    root /var/www/public; \n\
    location / { \n\
        try_files \$uri \$uri/ /index.php?\$query_string; \n\
    } \n\
    location ~ \.php$ { \n\
        try_files \$uri =404; \n\
        fastcgi_split_path_info ^(.+\.php)(/.+)$; \n\
        fastcgi_pass 127.0.0.1:9000; \n\
        fastcgi_index index.php; \n\
        include fastcgi_params; \n\
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name; \n\
        fastcgi_param PATH_INFO \$fastcgi_path_info; \n\
    } \n\
}" > /etc/nginx/sites-available/default

ENV DB_CONNECTION=mysql

EXPOSE 80

CMD php-fpm -D && nginx -g "daemon off;"
