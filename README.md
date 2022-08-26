<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Project

This is the test-project (newbe test task).

### Requirements

- non-root user with sudo privileges
- Docker, Docker compose

## License

This is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Installation

- Goto "home" directory:
  - cd ~/
- Clone project from git repository to some folder (nbtt-pp): 
  - git clone https://github.com/saint-father/newbetesttask -b feature/PP-test-task nbtt-pp
- Goto project directory: 
  - cd nbtt-pp/
- Create Laravel-configuration file with DB configuration options: 
  - cp .env.example .env; nano .env;
- Set DB options (you can set any other DB_DATABASE, DB_USERNAME or DB_PASSWORD):  
  - DB_HOST=**db** 
  - DB_PORT=3306 
  - DB_DATABASE=nbtt-pp-db 
  - DB_USERNAME=nbtt-pp-user 
  - DB_PASSWORD=123
- Save and close .env
- Build application image:  
  - docker-compose build app
- Launch virtual environment:
    - docker-compose up -d
- Install Laravel modules and dependencies:
    - docker-compose exec app composer install
- Generate application key:
    - docker-compose exec app php artisan key:generate
- Install Laravel user authorization and management module:
    - docker-compose exec app php artisan passport:install

## API 

Local resource is available with **http://localhost:8000/** URL. 
For instance : **http://localhost:8000/api/login**
All requests content should be JSON type.
Headers:
- Accept: application/json
- Content-Type: application/json

#### POST http://localhost:8000/api/register
- parameters:
  - {"name":"Some User","password":"Qwerty123","email":"test123@email.com","password_confirmation":"Qwerty123"}
- response:
  - {"token": "eyJ0eXAiOi...h246JiCfufxn4J5M"}

#### GET http://localhost:8000/api/get-user
- headers:
  - Authorization: Bearer eyJ0eXAiOiJKV1QiLCJ...joiNGMwN2Y2YjUzYTNmYjdmMGQ2NDhhZjE4MTI2YmZkYWY1M2

#### POST http://localhost:8000/api/login
- parameters:
  - {"password":"Qwerty123","email":"test123@email.com"}
- response:
  - {"token": "eyJ0eXAiOi...h246JiCfufxn4J5M"}

#### GET http://localhost:8000/api/v1?method=rates<&currency=USD>
- headers:
    - Authorization: Bearer eyJ0eXAiOiJKV1QiLCJ...joiNGMwN2Y2YjUzYTNmYjdmMGQ2NDhhZjE4MTI2YmZkYWY1M2
- URL encoded parameters:
  - (optional) currency: USD or EUR & etc.
  - method: rates (single method available now)
- response:
  - {"status": "success","code": 200,"data": {"USD": {"buy": 21465.34,"sell": 21465.34}}}

#### POST http://localhost:8000/api/v1?method=rates
- headers:
    - Authorization: Bearer eyJ0eXAiOiJKV1QiLCJ...joiNGMwN2Y2YjUzYTNmYjdmMGQ2NDhhZjE4MTI2YmZkYWY1M2
- URL encoded parameters:
  - method: rates (single method available now)
- request body JSON parameters:
  - {"currency_to":"USD","currency_from":"BTC","value":2}
- response:
  - {"status": "success","code": 200,"data": {"currency_from": "BTC","currency_to": "USD","value": 2,"rate": 21297.44,"converted_value": "42,594.88"}}



## Troubleshooting

- If you installed "newbetesttask" previously, you may face “Name Already in Use by Container” Error in Docker. These containers should be removed:
  - docker rm -f nbtt-pp-app
  - docker rm -f nbtt-pp-nginx
  - docker rm -f nbtt-pp-db
- In database connection refused exception in API response please check DB_HOST=**db** option in .env file in root folder of Laravel.
