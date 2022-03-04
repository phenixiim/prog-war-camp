SHELL := /bin/bash

help: ## list available targets (this page)
	@awk 'BEGIN {FS = ":.*?## "} /^[0-9a-zA-Z_-]+:.*?## / {printf "\033[36m%-45s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

deploy: ## deploy to production server
	scp ./* aws_free:/home/ubuntu/www/ukazka

	dasdsad

	dsas

