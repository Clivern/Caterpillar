PHP           ?= php
COMPOSER      ?= composer
ARTISAN       ?= ./artisan


help: Makefile
	@echo
	@echo " Choose a command run in Maximus:"
	@echo
	@sed -n 's/^##//p' $< | column -t -s ':' |  sed -e 's/^/ /'
	@echo


## composer: Install Dependencies.
.PHONY: composer
composer:
	@echo ">> ============= Install Dependencies ============= <<"
	$(COMPOSER) install


## test: Run test cases.
.PHONY: test
test:
	@echo ">> ============= Running All Tests ============= <<"
	-cp .env.example .env
	$(ARTISAN) key:generate
	$(ARTISAN) test


## ci: Run all CI tests.
.PHONY: ci
ci: composer test
	@echo "\n==> All quality checks passed"


.PHONY: help
