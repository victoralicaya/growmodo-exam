## HOW TO INSTALL
I am using the latest Laravel 10 version, Vue JS 3 + Vite, and PHP 8.1
- composer install/update
- npm install
- copy .env.example to .env
- setup database connection in .env
- php artisan migrate --seed
- npm run serve / npm run build

The Admin user is in a seeder file /app/database/seeders/UserSeeder.php. You can find in this file the admin credentials.

Note: 
In this instruction, 'For guests, the Welcome page should have a title "Welcome, {username}", and two (2) buttons to Unsubscribe and Logout.' it didn't specify on what is the functionality of the 'Unsubscribe' button so I just created my own, you will find the functionality that I have implemented during testing of the system.
