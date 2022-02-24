SHELL := /bin/bash

help: ## list available targets (this page)
	@awk 'BEGIN {FS = ":.*?## "} /^[0-9a-zA-Z_-]+:.*?## / {printf "\033[36m%-45s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

run-sls: ## SLS
	cd sls_nodejs; sls invoke local --function test

deploy-sls: ## SLS DEPLOY
	cd sls_nodejs; sls deploy

run-php: ## PHP
	cd php; php run.php