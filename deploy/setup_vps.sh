#!/bin/bash

# ===========================================
# Script de Configuração VPS - Go77 API
# Ubuntu 24.04 LTS
# Domínio: go77destinos.online
# ===========================================

set -e

echo "=========================================="
echo "  CONFIGURAÇÃO VPS - GO77 API"
echo "=========================================="

# Cores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

# Variáveis
DOMAIN="go77destinos.online"
DB_NAME="go77app"
DB_USER="go77user"
DB_PASS="Go77@2025!Secure"
ROOT_PASS="Go77Root@2025!"
WEB_ROOT="/var/www/go77destinos.online"
GITHUB_REPO="https://github.com/hyagosilvaxds/api-go77.git"

echo -e "${YELLOW}[1/7] Atualizando sistema...${NC}"
apt update && apt upgrade -y

echo -e "${YELLOW}[2/7] Instalando Apache...${NC}"
apt install -y apache2
systemctl enable apache2
systemctl start apache2

# Habilitar módulos Apache
a2enmod rewrite
a2enmod headers
a2enmod ssl

echo -e "${YELLOW}[3/7] Instalando MySQL 8...${NC}"
apt install -y mysql-server

# Configurar MySQL
mysql -e "ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY '${ROOT_PASS}';"
mysql -u root -p"${ROOT_PASS}" -e "CREATE DATABASE IF NOT EXISTS ${DB_NAME} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root -p"${ROOT_PASS}" -e "CREATE USER IF NOT EXISTS '${DB_USER}'@'localhost' IDENTIFIED BY '${DB_PASS}';"
mysql -u root -p"${ROOT_PASS}" -e "GRANT ALL PRIVILEGES ON ${DB_NAME}.* TO '${DB_USER}'@'localhost';"
mysql -u root -p"${ROOT_PASS}" -e "FLUSH PRIVILEGES;"

echo -e "${GREEN}MySQL configurado!${NC}"
echo "  Database: ${DB_NAME}"
echo "  User: ${DB_USER}"
echo "  Password: ${DB_PASS}"

echo -e "${YELLOW}[4/7] Instalando PHP 8.3...${NC}"
apt install -y software-properties-common
add-apt-repository -y ppa:ondrej/php
apt update

apt install -y php8.3 php8.3-fpm php8.3-mysql php8.3-curl php8.3-gd \
    php8.3-mbstring php8.3-xml php8.3-zip php8.3-bcmath php8.3-intl \
    php8.3-soap php8.3-readline php8.3-cli libapache2-mod-php8.3

# Configurar PHP
sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 64M/' /etc/php/8.3/apache2/php.ini
sed -i 's/post_max_size = 8M/post_max_size = 64M/' /etc/php/8.3/apache2/php.ini
sed -i 's/max_execution_time = 30/max_execution_time = 300/' /etc/php/8.3/apache2/php.ini
sed -i 's/memory_limit = 128M/memory_limit = 256M/' /etc/php/8.3/apache2/php.ini
sed -i 's/display_errors = On/display_errors = Off/' /etc/php/8.3/apache2/php.ini

echo -e "${YELLOW}[5/7] Configurando diretório web...${NC}"
mkdir -p ${WEB_ROOT}
chown -R www-data:www-data ${WEB_ROOT}

# Instalar Git
apt install -y git

# Clonar repositório
cd ${WEB_ROOT}
if [ -d ".git" ]; then
    git pull origin main
else
    git clone ${GITHUB_REPO} .
fi

# Configurar permissões
chown -R www-data:www-data ${WEB_ROOT}
find ${WEB_ROOT} -type d -exec chmod 755 {} \;
find ${WEB_ROOT} -type f -exec chmod 644 {} \;
chmod -R 775 ${WEB_ROOT}/uploads

echo -e "${YELLOW}[6/7] Configurando Apache VirtualHost...${NC}"

# Criar VirtualHost HTTP
cat > /etc/apache2/sites-available/${DOMAIN}.conf << EOF
<VirtualHost *:80>
    ServerName ${DOMAIN}
    ServerAlias www.${DOMAIN}
    DocumentRoot ${WEB_ROOT}
    
    <Directory ${WEB_ROOT}>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    # Logs
    ErrorLog \${APACHE_LOG_DIR}/${DOMAIN}-error.log
    CustomLog \${APACHE_LOG_DIR}/${DOMAIN}-access.log combined
    
    # PHP
    <FilesMatch \.php$>
        SetHandler application/x-httpd-php
    </FilesMatch>
</VirtualHost>
EOF

# Desabilitar site default e habilitar nosso site
a2dissite 000-default.conf
a2ensite ${DOMAIN}.conf

# Reiniciar Apache
systemctl restart apache2

echo -e "${YELLOW}[7/7] Instalando SSL com Let's Encrypt...${NC}"
apt install -y certbot python3-certbot-apache

# Obter certificado SSL
certbot --apache -d ${DOMAIN} -d www.${DOMAIN} --non-interactive --agree-tos --email admin@${DOMAIN} || {
    echo -e "${YELLOW}SSL: Executando sem email...${NC}"
    certbot --apache -d ${DOMAIN} --non-interactive --agree-tos --register-unsafely-without-email || true
}

# Configurar renovação automática
echo "0 0 * * * root certbot renew --quiet" > /etc/cron.d/certbot-renew

# Configurar Firewall
echo -e "${YELLOW}Configurando Firewall...${NC}"
apt install -y ufw
ufw allow ssh
ufw allow 'Apache Full'
ufw --force enable

# Reiniciar serviços
systemctl restart apache2
systemctl restart mysql

echo ""
echo -e "${GREEN}=========================================="
echo "  CONFIGURAÇÃO CONCLUÍDA!"
echo "==========================================${NC}"
echo ""
echo "Informações de acesso:"
echo "  URL: https://${DOMAIN}"
echo "  MySQL Root: root / ${ROOT_PASS}"
echo "  MySQL App: ${DB_USER} / ${DB_PASS}"
echo "  Database: ${DB_NAME}"
echo "  Web Root: ${WEB_ROOT}"
echo ""
echo "Próximos passos:"
echo "  1. Importe o banco de dados MySQL"
echo "  2. Atualize config.php com as credenciais"
echo "  3. Teste os endpoints da API"
echo ""
