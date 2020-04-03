1. login to Linux system

2. Install Apache: sudo apt-get install apache2

3. Set Global ServerName to Suppress Syntax Warnings:

sudo nano /etc/apache2/apache2.conf

Inside, at the bottom of the file, add a ServerName directive, pointing to your primary domain name. If you do not have a domain name associated with your server, you can use your server’s public IP address:

ServerName server_domain_or_IP

4. Restart apache server
sudo systemctl restart apache2

5. Adjust firewall settings if you are using firewall to allow incoming traffic to apache server

6. Test that apache server setup is working by opening URL: http://your_server_IP_address

7. Install MySQL

8. Install PHP

sudo apt install php libapache2-mod-php php-mysql

####################################

9. install guzzle php

# Install Composer

curl -sS https://getcomposer.org/installer | php

#You can add Guzzle as a dependency using the composer.phar CLI:

php composer.phar require guzzlehttp/guzzle:~6.0

10. copy guzzle_test_script files into main guzzle folder.

11. copy backend file to correct folder

12. setup database and tables in mysql using backend files

  (create your own database, table and crosscheck the database details to map rest api data and
   later in the next step store the data into your own database table)

13. run guzzle script via cmd, it can perodically run using cron setup.

14. setup apache configuration to load website

15. copy website front end files to correct folder

16. access website and test