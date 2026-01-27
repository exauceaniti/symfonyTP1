SHELL := /bin/bash

tests:
	# 1. On supprime la base de test
	rm -f var/test.db
	# 2. On crée le schéma directement d'après les Entités (ignore les migrations)
	symfony console doctrine:schema:create --env=test
	# 3. On charge les données
	symfony console doctrine:fixtures:load -n --env=test
	# 4. On lance les tests
	symfony php bin/phpunit
.PHONY: tests