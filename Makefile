vendor: composer.json
	composer install
	touch vendor

test: vendor
	$(EXEC_PHP) vendor/bin/phpunit

psalm: vendor
	$(EXEC_PHP) vendor/bin/psalm

composer-check-require: vendor
	$(EXEC_PHP) vendor/bin/composer-require-checker check

composer-unused: vendor
	$(EXEC_PHP) vendor/bin/composer-unused

composer-validate:
	composer validate

check: test psalm composer-check-require composer-unused composer-validate

.PHONY: test psalm composer-check-require composer-unused composer-validate check
