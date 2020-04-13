<p align="center">
<img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400">
</p>

<p align="center">
<a href="https://app.codacy.com/manual/Fadhilamadan/thalamus?utm_source=github.com&utm_medium=referral&utm_content=Fadhilamadan/thalamus&utm_campaign=Badge_Grade_Dashboard"><img src="https://api.codacy.com/project/badge/Grade/57e45cefabb44bfa842231ab6d77a154" alt="Codacy Badge"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Thalamus

A health service search application addressed to health facility owners in developing their health services, as well as helping communities in the rungkut area to seek the location of health services and improve the health of everyone.

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.5/installation#installation)

Clone the repository

    git clone git@github.com:Fadhilamadan/thalamus.git

Switch to the repo folder

    cd thalamus

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000
    
**Make sure you set the correct database connection information before running the migrations**

    php artisan migrate
    php artisan serve
    
## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).