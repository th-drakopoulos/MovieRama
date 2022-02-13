## How to use
- Clone the repository with git clone
- Copy .env.example file to .env and edit database credentials there. Change SESSION_DRIVER=file to SESSION_DRIVER=cookie
- Run composer install
- Run php artisan key:generate
- Run php artisan migrate --seed (it has some seeded data for your testing)
- Run npm install
- Run npm run dev
- Run php artisan serve

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
