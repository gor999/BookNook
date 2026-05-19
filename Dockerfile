FROM php:8.2-fpm

# 1. Տեղադրում ենք համակարգային փաթեթները, Nginx-ը, Node.js-ը և NPM-ը միասին
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    nginx \
    nodejs \
    npm

# Մաքրում ենք քեշը
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Տեղադրում ենք PHP ընդլայնումները
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# 3. Տեղադրում ենք Composer-ը
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Սահմանում ենք աշխատանքային թղթապանակը
WORKDIR /var/www

# 4. ՊԱՏՃԵՆՈՒՄ ԵՆՔ ՆԱԽԱԳԾԻ ԲՈԼՈՐ ՖԱՅԼԵՐԸ (Միայն մեկ անգամ)
COPY . /var/www

# 5. Տեղադրում ենք PHP-ի կախվածությունները
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# 6. Տեղադրում ենք Node-ի փաթեթները և անում ենք Build (Այժմ ոչինչ չի ջնջվի)
RUN npm install
RUN npm run build

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

# Տվյալների բազայի ENV-ները
ENV DB_CONNECTION=mysql
ARG DB_HOST=mysql-3619758c-gor-6b78.j.aivencloud.com
ARG DB_PORT=19820
ARG DB_DATABASE=defaultdb
ARG DB_USERNAME=avnadmin
ARG DB_PASSWORD=AVNS_P0eF0a1wIhtLeyoBJXZ

ENV DB_HOST=$DB_HOST
ENV DB_PORT=$DB_PORT
ENV DB_DATABASE=$DB_DATABASE
ENV DB_USERNAME=$DB_USERNAME
ENV DB_PASSWORD=$DB_PASSWORD

EXPOSE 80

CMD php-fpm -D && nginx -g "daemon off;"