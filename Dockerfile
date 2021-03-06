FROM debian:buster
MAINTAINER Lukas Plevac

RUN apt-get update && \
    apt-get -y upgrade && DEBIAN_FRONTEND=noninteractive apt-get -y install \
    apache2 php php-auth-sasl php-common php-curl php-mail php-mbstring php-mysql \
    php-net-smtp php-net-socket php-pear php-xml php-fpm php-json php-opcache \
    php-readline libapache2-mod-php curl cron

#enable mods
RUN a2enmod php7.3 && \
    a2enmod rewrite

#add system
ADD src/. /var/www/data
RUN chown -R www-data /var/www/data

#add apache config
ADD apache-config.conf /etc/apache2/sites-enabled/000-default.conf

#hide server info
RUN echo 'ServerSignature Off' >> /etc/apache2/apache2.conf && \
    echo 'ServerTokens Prod' >> /etc/apache2/apache2.conf && sed -e "s/expose_php = On/expose_php = Off/" /etc/php/7.3/apache2/php.ini > /etc/php/7.3/apache2/php.ini


#ENTRYPOINT
ADD entrypoint.sh /

CMD ["/bin/bash", "/entrypoint.sh"]
