FROM php:8.2-apache

# เปิด mod_rewrite ถ้าใช้ .htaccess
RUN a2enmod rewrite

# กำหนดสิทธิ์และ config Apache ให้เข้าถึง /var/www/html
RUN echo '<Directory /var/www/html>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/docker-override.conf \
    && a2enconf docker-override
