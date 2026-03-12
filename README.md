# Yii Test Project

## About the Project

This is a test REST API project built with **Yii2 Basic**.

Yii2 Basic was chosen for this task because its functionality is sufficient for the required API, and its minimal configuration allows focusing on business logic rather than framework setup.

The project includes:

- REST API
- database migrations
- seeders for generating test data
- Docker-based environment
- automated API tests

The installation and startup process are fully automated using **Docker** and **Makefile**.

---

## Project Structure

```bash
app/
 ├── commands/          # console commands
 │   └── seeders/       # seeders
 ├── controllers/       # API controllers
 ├── models/            # models
 ├── migrations/        # database migrations
 ├── config/            # application configuration
 ├── tests/
 │   └── api/           # API tests
 │   └── unit/          # Seeders tests
 │   └── console/       # Console command tests
docker/                 # docker configuration
```

## Requirements

- Docker
- Docker Compose
- Make

## Quick Start

Before starting the project you must fill in `.env.example` so that it contains no empty values.

After that run:

```bash
make start
```

This command will:

- build docker containers
- install dependencies
- start the application
- run migrations
- seed the database
- run api tests

## Manual installation

In most cases the project can be started using the command described in the **Quick Start** section.

If the automatic setup does not work for some reason, the project can be installed manually by following the steps below.

1. Clone the repository

```bash
git clone git@github.com:lpovhan/yiitest.git
cd yiitest
```

2. Configure environment
   Main parameters are configured through .env.example

```bash
cp .env.example .env && cp .env.example app/.env
```

3. Build Docker images

```bash
docker-compose build
```

4. Install dependencies

```bash
docker-compose run --rm composer install --no-scripts --optimize-autoloader
```

5. Start containers

```bash
docker-compose up -d
```

6. Run migrations

```bash
docker-compose run --rm app php yii migrate
```

7. Run seeders

```bash
docker compose exec app php yii migrate seed/run
```

8. Run API-tests

```bash
php vendor/bin/codecept build
vendor/bin/codecept run tests/api/
```

## Testing

API tests are implemented using Codeception.

Run tests with:

```bash
vendor/bin/codecept run tests/api/
```

Seeder tests are implemented like unit tests

Run tests with:

```bash
vendor/bin/codecept run tests/unit/seeders
```

Seed command test is implemented like console tests

```bash
vendor/bin/codecept run tests/console
```

Currently tests run against the main database.
In real project a separate test database should be used.

## API Endpoints

Get list of albums:

```bash
GET http://localhost/users?page=2
```

Example response:

```bash
{
  "status": "ok",
  "total": 2,
  "page": 2,
  "pageSize": 10,
  "data": [
    {
      "id": 1,
      "first_name": "Austyn",
      "last_name": "Torphy"
    }
  ]
}
```

```bash
GET http://localhost/users/1
```

Example response:

```bash
{
  "status": "ok",
  "data": [
    {
      "id": 1,
      "first_name": "John",
      "last_name": "Doe",
      "albums": [
        {
          "id": 1,
          "title": "My photo",
        }
      ]
    }
  ]
}
```

```bash
GET http://localhost/albums
```

Example response:

```bash
{
  "status": "ok",
  "total": 4,
  "page": 1,
  "pageSize": 10,
  "data": [
    {
      "id": 1,
      "title": "My album"
    }
  ]
}
```

```bash
GET http://localhost/albums/1
```

Example response:

```bash
{
  "status": "ok",
  "data": [
    {
      "id": 1,
      "title": "My album",
      "first_name": "John",
      "last_name": "Doe",
      "photos": [
        {
          "id": 1,
          "title": "My photo",
          "url": "http://localhost/images/seed/photo_69affd3ab2cec.jpg"
        }
      ]
    }
  ]
}
```

## Architecture Decisions

### Yii2 Basic

Yii2 Basic was chosen because:

- the task does not require a complex backend architecture
- only a REST API is needed
- minimal configuration speeds up development

### Docker

Docker is used for:

- environment reproducibility
- simplified project setup
- dependency isolation

### Seeders

Seeders are implemented as separate classes.

Reasons:

- independent testing
- possible reuse
- better separation of responsibilities

In this project seeders are executed via a console orchestrator command.

### DTO (Data Transfer Objects)

The project uses DTOs for API responses instead of the standard ActiveRecord fields() method.

Reasons:

- Strict Contract: Ensures the API always returns a predictable structure, regardless of internal DB changes.
- Separation of Concerns: Decouples Database logic (ActiveRecord) from Presentation logic (API JSON).
- Flexibility: Allows different data representations for the same model (e.g., Short version for lists and Full version for detailed views) without complex scenario management.
- Performance: Prevents "leaking" sensitive or heavy data fields that are not needed for a specific endpoint.

## Limitations

The project is intended for development environment.

Reasons:

- seeders use Faker
- tests run against the main database

Also, the test task includes a password for the user but does not define an API authentication mechanism.
Therefore authentication is not implemented intentionally in this solution.

In real project the API should be protected using authentication mechanisms.

## Future Improvements

For a production-ready system the following could be added:

- separate test database
- CI/CD pipeline
- OpenAPI / Swagger documentation
- API rate limiting
- Redis caching
- centralized logging
