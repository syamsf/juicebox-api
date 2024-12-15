# API Documentation

## Running The Application

This application can be set up and run in two primary ways:
- **Directly using `php artisan serve`**
- **Using Docker**

## Prerequisites
Ensure you have the following installed in your development environment:
- PHP >= 8.2
- Composer
- Redis (for caching)
- RabbitMQ (for background job queue)
- Docker and Docker Compose (for Docker-based setup)

---

## A. Directly Using `php artisan serve`
Steps:
1. Move into src directory.
```
cd src
```
2. Set Up the `.env` file. Copy `.env.example` file into `.env` and update the following `.env` settings as needed for your environment:
```
# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Mail config
MAIL_MAILER=smtp
MAIL_HOST=smtp_address
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

# Redis Config
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
   
# RabbitMQ Config
QUEUE_CONNECTION=rabbitmq
RABBITMQ_HOST=
RABBITMQ_PORT=
RABBITMQ_USER=
RABBITMQ_PASSWORD=
RABBITMQ_VHOST=/

# WEATHER CONFIG
WEATHER_OPENWEATHERMAP_API_KEY=
WEATHER_WEATHERAPI_API_KEY=
WEATHER_ADAPTER=OPEN_WEATHER_MAP
```
3. Run the following commands to install the Laravel dependencies.
```
composer install
```
4. Run database migration from the src directory.
```
php artisan migrate
```
5. Generate JWT secret
```
php artisan jwt:secret
```
6. Start the development server.
```
php artisan serve
```
By default, the application will run on [http://127.0.0.1:8000]().


## B. Using Docker
1. Set Up the `.env` file. Copy `.env.example` file into `.env` and update the following `.env` settings as needed for your environment:
```
# Database Configuration
DB_CONNECTION=mysql
DB_HOST=db #docker container name
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=root
DB_PASSWORD=password

# Mail config
MAIL_MAILER=smtp
MAIL_HOST=mailpit # mailpit is provided for testing purposes in docker compose
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

# Redis Config
REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
   
# RabbitMQ Config
QUEUE_CONNECTION=rabbitmq
RABBITMQ_HOST=rabbitmq
RABBITMQ_PORT=5672
RABBITMQ_USER=admin
RABBITMQ_PASSWORD=rabbitmq
RABBITMQ_VHOST=/

# WEATHER CONFIG
WEATHER_OPENWEATHERMAP_API_KEY=
WEATHER_WEATHERAPI_API_KEY=
WEATHER_ADAPTER=OPEN_WEATHER_MAP
```
2. Generate the jwt secret using `php artisan jwt:secret`
3. Make sure that you're in the root directory of the project.
```
|--- src
|--- docker
```
4. Update the permission of storage directory.
```
chmod -R 777 src/storage/logs
chmod -R 777 src/storage/framework
```
5. Run the docker compose command to start the container.
```
docker compose -f docker/compose/dev.docker-compose.yml up -d
```
By default, the application will run on [http://127.0.0.1:8090]().

## Running the Test
```
./src/vendor/bin/phpunit src/tests/Feature/Modules/Post/Controllers/PostsControllerTest.php
./src/vendor/bin/phpunit src/tests/Feature/Modules/User/Controllers/UserControllerTest.php
./src/vendor/bin/phpunit src/tests/Feature/Modules/Weather/Controllers/WeatherControllerTest.php
```

## Setup Weather API
1. The `.env` file includes configurations for the API keys of different weather API providers:
```
WEATHER_OPENWEATHERMAP_API_KEY=
WEATHER_WEATHERAPI_API_KEY=
```
2. You can select your preferred weather API provider by setting the `WEATHER_ADAPTER` to either `OPEN_WEATHER_MAP` or `WEATHER_API`
```
WEATHER_ADAPTER=OPEN_WEATHER_MAP
```

## Send Welcome Mail Manually
Use this command to send the welcome mail to user.
```
php artisan user:welcome-mail
```
