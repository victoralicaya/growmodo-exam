## HOW TO INSTALL
I am using the latest Laravel 10 version, Vue JS 3 + Vite, and PHP 8.1
- composer install/update
- npm install
- copy .env.example to .env
- setup database connection in .env
- php artisan migrate --seed
- npm run dev / npm run build

The Admin user is in a seeder file /app/database/seeders/UserSeeder.php. You can find in this file the admin credentials.
