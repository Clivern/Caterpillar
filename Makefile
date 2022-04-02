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


## fix: Fix code format.
.PHONY: fix
fix:
	@echo ">> ============= Fix Code Format ============= <<"
	./vendor/bin/php-cs-fixer fix


## fix-diff: Get code format diff.
.PHONY: fix-diff
fix-diff:
	@echo ">> ============= Get Code Format Diff ============= <<"
	./vendor/bin/php-cs-fixer fix --diff --dry-run -v


## run: Run.
.PHONY: run
run:
	@echo ">> ============= Run Application ============= <<"
	$(ARTISAN) serve


## ci: Run all CI tests.
.PHONY: ci
ci: composer test
	@echo "\n==> All quality checks passed"


.PHONY: help
