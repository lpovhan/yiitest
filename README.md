# Yii Test Project

## Installation

1. Clone the repository
    ```bash
    git clone <repository-url>
    cd yiitest
    ```

2. Install dependencies
    ```bash
    composer install
    ```

3. Configure environment
    ```bash
    cp .env.example .env
    ```

## Docker Setup

1. Build Docker image
    ```bash
    docker-compose build
    ```

2. Start containers
    ```bash
    docker-compose up -d
    ```

3. Verify containers are running
    ```bash
    docker-compose ps
    ```

## Run Migrations

Execute database migrations


1. Убедится, что у енв.ехаьзду стоят правильные настройки
./init.sh

make up

basic, а не advanced, потому что нет фронта