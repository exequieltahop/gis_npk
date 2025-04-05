GUIDE


requirements
- php 8.2 above
- mysql
- git


steps
- clone this main repo
- in the terminal type "git clone https://github.com/exequieltahop/gis_npk.git"
- after cloned copy the env.example in the root directory/ same directory as env.example
- type "composer install"
- then type "php artisan key:generate"
- changes the database configuration in the .env file 
- type in the terminal "php artisan migrate --seed"
- see the username and password in the app/database/seeder/DatabaseSeeder.php
