<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About
1. Test Api App
1. Regenerate documentation:  Run `php artisan l5-swagger:generate`
1. Api Documentation - http://YOUR_DOMAIN/api/documentation

## Installation
0. Remember: If you want to do something, but You don't know how can you do it, please ask your colleagues.
1. Clone this project into your local workspace
1. Duplicate the `.env.example` file in the project root and set new name `.env`
1. In your `.env` file insert your database credentials.
    1. In this project we use only mysql.
    2. **You should create database by yourself.**
1. In your `.env` file change the following settings:
    1. APP_URL to your local host name.

1. Open your favorite console in the project root and run `composer install` or `composer i` to install all php dependencies.
1. Run `npm install` or `npm i` if you are going to change frontend structure
1. Run `php artisan project:install` to install project.
1. Congratulation! You are the best!

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
