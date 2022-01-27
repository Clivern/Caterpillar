PHP           ?= php
COMPOSER      ?= composer
ARTISAN       ?= ./artisan


help: Makefile
	@echo
	@echo " Choose a command run in Maximus:"
	@echo
	@sed -n 's/^##//p' $< | column -t -s ':' |  sed -e 's/^/ /'
	@echo


## test: Run test cases.
.PHONY: test
test:
	@echo ">> ============= Running All Tests ============= <<"
	$(ARTISAN) test


## ci: Run all CI tests.
.PHONY: ci
ci: test
	@echo "\n==> All quality checks passed"


.PHONY: help
