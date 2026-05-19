FROM php:8.2-fpm

# Համակարգային փաթեթներ
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

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Node.js 22 տեղադրում
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs

# PHP ընդլայնումներ
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . /var/www

# PHP կախվածություններ
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Tailwind-ի և Vite-ի ճիշտ տեղադրում
# Օգտագործում ենք NODE_ENV=development build-ի ժամանակ, որպեսզի 
# devDependencies-ները (Tailwind) հասանելի լինեն
ENV NODE_ENV=development
RUN npm install
RUN npm run build
ENV NODE_ENV=production

# Իրավունքներ
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Nginx կոնֆիգուրացիա
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

# Տվյալների բազայի ENV-ներ
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