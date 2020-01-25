# SAMTA
Welcome to Samta, the newest money transfer app on the local web \*winks*. Samta is an acronym for Simple Accounts and Money Transfers Application.

### How to set up
1. Clone project from GitHub
2. After successful cloning, switch to project directory and run `composer install`
3. Next, compile the assets by running `npm install && npm run dev`
4. Create a database and configure `.env` file with necessary credentials (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`)
5. Generate application key with `php artisan key:generate`
6. Load up DB schema with `php artisan migrate --seed`
7. Spin up the app with `php artisan serve`
8. Enjoy!