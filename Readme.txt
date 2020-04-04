Youtube Presentation Video link https://www.youtube.com/watch?v=sGXrN80vZSE

Website used for php code: https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php

Team 3 

Members:
Astghik Hovhannisyan 	(contributed developing welcome page, sql commands, insert statements)
Aram Balayan		(contributed developing welcome, sql commands, debugging)
Wes Flamenco		(contributed developing login, welcome, sql commands, php code)

installation: 
1. Install Xampp  found https://www.apachefriends.org/index.html
2. activate both mysql and apache server in the Xampp control 
3. place the PHP folder in C:\xampp\htdocs
4. import databases into phpmyadim from the Xampp control panel ( use the admin button next to the mysql activation to acess the phpmyadmin).
5. creat user using this command 
GRANT SELECT, INSERT, UPDATE, DELETE ON *.* TO 'Wes'@'localhost'; ( or change login credentials in config.php field db username and db password).
6. run program by going to you browser and enter http://localhost/PHP/welcome.php