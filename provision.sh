#yum更新
#更新数が多いのでひとまずコメントアウト
#sudo yum -y update

############ install ##########
sudo rpm -Uvh http://ftp.iij.ad.jp/pub/linux/fedora/epel/6/x86_64/epel-release-6-8.noarch.rpm
sudo rpm -Uvh http://rpms.famillecollet.com/enterprise/remi-release-6.rpm
sudo rpm -Uvh http://pkgs.repoforge.org/rpmforge-release/rpmforge-release-0.5.2-2.el6.rf.i686.rpm

#php5.6
sudo yum install -y --enablerepo=remi --enablerepo=remi-php56 php php-opcache php-devel php-mbstring php-mcrypt php-mysqlnd php-phpunit-PHPUnit php-pecl-xdebug php-pecl-xhprof

#mysql5.5
sudo yum install -y --enablerepo=remi mysql mysql-server mysql-devel mysql-libs

#apache
sudo yum install -y httpd

############ setting ###########
###confファイル生成
#httpd.conf修正
sudo cp /etc/httpd/conf/httpd.conf /etc/httpd/conf/httpd.conf.bak
sudo chmod 0777 /etc/httpd/conf/httpd.conf
echo 'NameVirtualHost *:80' >> /etc/httpd/conf/httpd.conf
sudo chmod 0644 /etc/httpd/conf/httpd.conf

#local
sudo touch /etc/httpd/conf.d/virtualhost-products.conf
sudo chmod 0777 /etc/httpd/conf.d/virtualhost-products.conf
sudo cat <<EOF > /etc/httpd/conf.d/virtualhost-products.conf
<VirtualHost *:80>
    ServerName localhost
    DocumentRoot "/vagrant/products/public/"
    SetEnv CI_ENV development
</VirtualHost>
EOF
sudo chmod 0644 /etc/httpd/conf.d/virtualhost-products.conf

#mysql
sudo service mysqld start
mysql -uroot < /vagrant/createdb.sql

#composer
cd ~
curl -sS https://getcomposer.org/installer | sudo php
mv composer.phar /usr/local/bin/composer

cd /vagrant/products
composer install

#alias
#echo 'alias my="mysql -u root -D products"' >> ~/.bashrc
#source ~/.bashrc

#起動
sudo service httpd start

#自動起動設定
sudo chkconfig httpd on
sudo chkconfig mysqld on
