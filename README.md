<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Project

This is the test-project (newbie task).

### Requirements

- non-root user with sudo privileges
- Linux x86_64 (for instance Ubuntu 20.04)
- PHP 7/8
- MySQL 5.7+

### Dependancies

- **[Categoryproducts package](https://github.com/saint-father/categoryproducts)**

## License

This is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Installation
- Create database in MySQL, create user and grate privileges to MySQL-user
- Goto "home" directory (or other project-directory):
    - cd ~/
- Clone project from git repository to some folder (nbtt-pp):
    - git clone https://github.com/saint-father/newbetesttask -b feature/NTT-e-commerce-rest-api newbetesttask
- Goto project directory:
    - cd newbetesttask/
- Create Laravel-configuration file with DB configuration options:
    - cp .env.example .env; nano .env;
- Set DB options (you can set any other DB_DATABASE, DB_USERNAME or DB_PASSWORD):
    - DB_HOST=**db**
    - DB_PORT=3306
    - DB_DATABASE=newbetesttask
    - DB_USERNAME=user
    - DB_PASSWORD=123
- Save and close .env
- Install Laravel modules and dependencies:
```console
composer install
```
Add "categoryproducts" repository to composer.json:
```json
"repositories": [
        {
            "type": "git",
            "url": "https://github.com/saint-father/categoryproducts.git"
        }
    ],
```
Install the module:
```console
composer require alexfed/categoryproducts:dev-master#v0.0.6
```
- Generate application key:
    - php artisan key:generate
- Install Laravel user authorization and management module:
    - php artisan passport:install

## API

Local resource is available with **http://localhost:80/** URL.
For instance : **http://localhost:80/api/login**
All requests content should be JSON type.
Headers:
- Accept: application/json
- Content-Type: application/json

#### POST http://localhost:80/api/register
- parameters:
```json
{"name":"Some User","password":"Qwerty123","email":"test123@email.com","password_confirmation":"Qwerty123"}
```
- response:
```json
{"token": "eyJ0eXAiOi...h246JiCfufxn4J5M"}
```
#### GET http://localhost:80/api/get-user
- headers:
    - Authorization: Bearer eyJ0eXAiOiJKV1QiLCJ...joiNGMwN2Y2YjUzYTNmYjdmMGQ2NDhhZjE4MTI2YmZkYWY1M2

#### POST http://localhost:80/api/login
- parameters:
```json
{"password":"Qwerty123","email":"test123@email.com"}
```
- response:
```json
{"token": "eyJ0eXAiOi...h246JiCfufxn4J5M"}
```
#### GET http://localhost:80/api/products/
- headers:
    - Authorization: Bearer eyJ0eXAiOiJKV1QiLCJ...joiNGMwN2Y2YjUzYTNmYjdmMGQ2NDhhZjE4MTI2YmZkYWY1M2
- response:
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "test-product-1",
            "description": "Description for <strong>test-product-1</strong>",
            "isActive": 1
        },
        {
            "id": 2,
            "name": "test-product-2",
            "description": "Description for <strong>test-product-2</strong>",
            "isActive": 1
        },
        {
            "id": 3,
            "name": "test-product-3",
            "description": "Description for <strong>test-product-3</strong>",
            "isActive": 1
        }
    ],
    "message": "Products retrieved successfully."
}
```
#### POST http://localhost:80/api/products/
- headers:
    - Authorization: Bearer eyJ0eXAiOiJKV1QiLCJ...joiNGMwN2Y2YjUzYTNmYjdmMGQ2NDhhZjE4MTI2YmZkYWY1M2
- request body JSON parameters:
```json
{
    "name": "test-product-1",
    "description": "Description for <strong>test-product-1</strong>",
    "isActive": true
}
```
- response:
```json
{
    "success": true,
    "data": {
        "name": "test-product-1",
        "description": "Description for <strong>test-product-1</strong>",
        "isActive": true,
        "id": 2
    },
    "message": "Product created successfully."
}
```
