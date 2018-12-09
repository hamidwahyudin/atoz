## How To Install
- Clone this repository
- Run composer install
- Copy .env.example to .env
- Configure the database setting
- Change QUEUE_CONNECTION to database (QUEUE_CONNECTION=database)
- Run php artisan migrate
- php artisan queue:work
- Run the orderexpired route every 5 minutes (Cronjob) to set expired order
- Done

Build with Laravel 5.7