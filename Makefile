install:
	docker-compose run -u root --rm composer update
	docker-compose run -u root --rm composer dump-autoload

create-env:
ifeq (,$(wildcard ./source/.env))
	cp source/.env.example source/.env
endif
ifeq (,$(wildcard /.env))
	cp .env.example .env
endif

run-project:
	docker-compose up -d

migrate:
	docker-compose run --rm artisan migrate:fresh --seed

run-worker:
	docker-compose run --rm artisan queue:work

run-tests:
	docker-compose exec php php artisan test

test: create-env install run-tests
up: create-env install migrate run-project run-worker