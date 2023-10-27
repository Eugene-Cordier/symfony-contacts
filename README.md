# PHP symfony-contacts

## Cordier Eugène

## Installation / Configuration

### installation composer
- installer composer: composer install  
- vérifier la version de composer : composer --version (version 2.6.5)
- mettre à jour si besoin : composer self-update
### installation symfony
- installation symfony :
wget https://get.symfony.com/cli/installer -O - | bash
- Vérifiez le bon fonctionnement de l'exécutable: symfony self:version  
- Contrôlez la compatibilité du système: symfony check:requirements  --verbose

## scripts

- composer start : lance le serveur web de test
- composer tests:cs : lance la commande de vérification du code par PHP CS Fixer
- composer fix:cs : lance la commande de correction du code par PHP CS Fixer
- composer test:codecption : clean le output dossier et le code généré
- composer test : lance test:codecption et fix:cs

## autre 
- config DataBase .env.local : DATABASE_URL="mysql://${DB_USER}:${DB_PASS}@${DB_SERVER}/${DB_DBNAME}?serverVersion=${DB_VERSION}"
- lancer les tests: php vendor/bin/codecept run  
