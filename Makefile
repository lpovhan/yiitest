init: check-env
	@echo "Initializing .env files..."
	@if [ ! -f .env ]; then cp .env.example .env; fi
	@if [ ! -f app/.env ]; then cp .env.example app/.env; fi

check-env:
	@echo "Checking .env.example"
	@empty_vars=$$(grep -E '^[A-Z_]+=' .env.example | awk -F= '{if($$2=="") print $$1}'); \
	if [ ! -z "$$empty_vars" ]; then echo "Error: not filled variables .env.example: $$empty_vars"; exit 1; fi

build: init
	docker compose build --no-cache
	docker-compose run --rm composer install --no-scripts --optimize-autoloader

start: build
	docker-compose up -d
	sleep 10
	docker compose exec app php yii migrate
	docker compose exec app php yii migrate seed/run
	docker compose exec app php vendor/bin/codecept build
	docker compose exec app vendor/bin/codecept run tests/api/

test:
	docker compose exec app vendor/bin/codecept run

restart:
	docker compose down
	docker compose up -d

stop:
	docker compose down
