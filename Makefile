SHELL := /bin/bash

help: ## list available targets (this page)
	@awk 'BEGIN {FS = ":.*?## "} /^[0-9a-zA-Z_-]+:.*?## / {printf "\033[36m%-45s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

rlds: ## run local docker server in current folder
	docker run --net my-network --mount type=bind,source=/Users/dj/__work/collabim/prog_kurz,target=/var/www/html --name my-webserver -d -p 8082:80 daweedpanic/php-pdo_mysql

rr: ## run redis
	docker run --name some-redis -p=6379:6379 --net my-network -d redis

rm: ## run mysql/mariadb
	docker run --name some-mysql -p=3307:3306 --net my-network -e MYSQL_ROOT_PASSWORD=my-secret-pw -d mariadb:latest

krall: ## kill and remove all
	docker stop my-webserver || true
	docker stop some-redis || true
	docker stop some-mysql || true
	docker rm my-webserver || true
	docker rm some-redis || true
	docker rm some-mysql || true
	docker network rm my-network || true

sall: ## start all - mysql, redis, apache
	docker network create my-network
	make rr
	make rm
	make rlds

src:   ## show running containers
	docker ps


