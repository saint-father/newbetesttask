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
- Clone project from git repository to some folder (nbtt-pp): git clone https://github.com/saint-father/newbetesttask -b feature/PP-test-task nbtt-pp
- Goto project directory: cd nbtt-pp/
- Create Laravel-configuration file with DB configuration options: cp .env.example .env; nano .env;
- Set DB options (you can set any other DB_DATABASE, DB_USERNAME or DB_PASSWORD): DB_HOST=db
  DB_PORT=3306
  DB_DATABASE=nbtt-pp-db
  DB_USERNAME=nbtt-pp-user
  DB_PASSWORD=123
- Save and close .env
- Build applicatioon image: docker-compose build app
- Launch virtual environment: docker-compose up -d
- Install Laravel modules and dependencies: docker-compose exec app composer install
- Generate application key: docker-compose exec app php artisan key:generate
- Install Laravel user authorization and management module: php artisan passport:install
- docker rm -f nbtt-pp-app
- docker rm -f nbtt-pp-nginx
- docker rm -f nbtt-pp-db
