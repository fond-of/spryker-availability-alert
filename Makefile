.PHONY: update
update:
	composer update

.PHONY: install
install:
	composer install --no-dev

.PHONY: install-dev
install-dev:
	composer install

.PHONY: phpcs
phpcs:
	./vendor/bin/phpcs --standard=./vendor/spryker/code-sniffer/Spryker/ruleset.xml ./src/

.PHONY: phpcbf
phpcbf:
	./vendor/bin/phpcbf --standard=./vendor/spryker/code-sniffer/Spryker/ruleset.xml ./src/

.PHONY: phpstan
phpstan:
	./vendor/bin/phpstan analyse -l 4 ./src

.PHONY: codeception
codeception:
	./vendor/bin/codecept run

.PHONY: phpcpd
phpcpd:
	./vendor/bin/phpcpd ./src --exclude vendor tests

.PHONY: grumphp
grumphp: phpcs codeception phpmd phpcpd

.PHONY: test
test: install-dev phpcs codeception phpcpd

