SHELL := /bin/bash

help: ## list available targets (this page)
	@awk 'BEGIN {FS = ":.*?## "} /^[0-9a-zA-Z_-]+:.*?## / {printf "\033[36m%-45s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

list-prerequisites: ## SLS
	echo "npm"
	echo "composer"
	echo "pipenv"

run-unit-calculator-test: ## SLS
	cd phpunit; vendor/bin/phpunit --filter testSum* ./CalculatorTest.php

run-unit-ex-rate-test: ## SLS
	cd phpunit; vendor/bin/phpunit --filter testParseTxt ./ExchangeRatesParserTest.php

run-robot-example: ## SLS
	cd robot; robot example.robot

run-dredd-example: ## SLS
	cd dredd; dredd

install-dredd: ## SLS
	cd dredd; npm install -g dredd

install-phpunit: ## SLS
	cd phpunit; composer install

install-robot: ## SLS
	pip install robotframework
	pip install robotframework-selenium2library