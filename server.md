//Se connecter à la machine avec putty (ip, 13.39.171.190 et la clé ssh pascuit-key.ppk)

//Lancer ensuite les commandes suivantes pour installer les différents composants

//installation php
sudo dnf update -y
sudo dnf install -y httpd wget php-fpm php-mysqli php-json php php-devel

//installation de symfony cli
curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.rpm.sh' | sudo -E bash
sudo dnf install symfony-cli

//installation de composer
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'e21205b207c3ff031906575712edab6f13eb0b361f2085f1f1237b7126d785e826a450292b6cfd1d64d92e6563bbde02') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
sudo mv composer.phar /usr/local/bin/composer

//Installation de MYSQL Community
wget https://dev.mysql.com/get/mysql80-community-release-el9-3.noarch.rpm

//recuperation du password temporaire du user root initialiser a l'installation
sudo grep 'temporary password' /var/log/mysqld.log

//changement du password temporaire (caractere speciaux % et # pas pratiques)
mysql -u root -p
ALTER USER 'root'@'localhost' IDENTIFIED BY 'iLnkZfi$7W1';

//cloner le projet dans le repertoire /home/ec2-user/
cd /home/ec2-user/
git clone https://gitlab.com/aurelie-parant/laprairiesymfony.git


//renseignement du password dans la configuration symfony
vi /home/ec2-user/laprairiesymfony/.env
ajouter les password dans l'url DATABASE_URL="mysql://root:password@ etc...