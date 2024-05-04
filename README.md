Install:

mysql server:
1. install TablePlus
2. run mysql.server start command in terminal
3. create a new database in Tableplus

1. git clone https://github.com/AMDAV-Solutions/nova-cpc.git ppc
2. cd ppc
3. composer install
4. cp .env.example .env
5. npm install
6. Add your database credentials in the .env file in DB_DATABASE, DB_USERNAME, DB_PASSWORD
7. Create users table: `php artisan migrate --seed`
8. Generate application key: `php artisan key:generate`
9. php artisan serve
10. npm run dev
14. navigate to localhost:8000 to use the app
