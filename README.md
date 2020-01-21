<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Run Project
    
    * Clone the repo: git clone https://github.com/mariliasoares/sistema-contatos.git
    * cd to project folder
    * Run: composer install
    * Create file .env: cp .env.example .env 
          and modify .env with your credencials database
    * Run php artisan key:generate to generate the app key
    * Run npm install
    * Run composer require laravel/passport
          php artisan passport:install
          php artisan vendor:publish --tag=passport-migrations
          php artisan migrate
    * create a profile folder inside public/img

    ** @if (GD Library extension not available with this PHP installation)
    ** https://stackoverflow.com/questions/34009844/gd-library-extension-not-available-with-this-php-installation-ubuntu-nginx
    ** @endif
