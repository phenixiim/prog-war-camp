SHELL := /bin/bash

help: ## list available targets (this page)
	@awk 'BEGIN {FS = ":.*?## "} /^[0-9a-zA-Z_-]+:.*?## / {printf "\033[36m%-45s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

rlds: ## run local docker server in current folder
	docker run -d -p 8082:80 --mount type=bind,source="$(pwd)/.",target=/var/www/html php:apache

klds:   ## kill docker server
	docker ps|grep php:apache|awk '{print $1}'|xargs docker stop

src:   ## show running containers
	docker ps


