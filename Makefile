#vars
c = php

start: cp-env build composer-install yarn yarn-build migrate
up:
	@docker-compose up -d
down:
	@docker-compose down
down-v:
	@docker-compose down -v
build:
	@docker-compose up -d --build
logs:
	@docker-compose logs -f $c
env:
	@docker-compose exec $c sh
migrate:
	@docker-compose exec php sh -c "bin/console doctrine:migrations:migrate"
cp-env:
	cp .env.dist .env
yarn:
	@docker-compose run node sh -c "yarn"
yarn-build:
	@docker-compose run node sh -c "yarn build"
composer-install:
	@docker-compose exec php composer install
analyse:
	@docker-compose exec php vendor/bin/phpstan analyse -l 9 --memory-limit 1G src

