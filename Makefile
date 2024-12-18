stan:
	@docker-compose exec php vendor/bin/phpstan analyse --memory-limit=2G --xdebug
cs:
	@docker-compose exec php vendor/bin/phpcs app
cbf:
	@docker-compose exec php vendor/bin/phpcbf app
test:
	@docker-compose exec php php artisan test
pint:
	@docker-compose exec php vendor/bin/pint
