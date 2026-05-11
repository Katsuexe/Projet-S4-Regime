# Application de Gestion Regime Alimentaire

[![PHP Version](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![CodeIgniter](https://img.shields.io/badge/CodeIgniter-4.5+-red.svg)](https://codeigniter.com)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange.svg)](https://mysql.com)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

Une application web de gestion de regimes alimentaires developpee avec CodeIgniter 4.

## Technologies Utilisees

- Backend : PHP 8.2+, CodeIgniter 4.5+
- Base de donnees : MySQL 8.0+
- Frontend : Bootstrap 5, JavaScript ES6+
- Graphiques : Chart.js
- PDF : DomPDF

## Prerequis

- PHP 8.2 ou superieur
- MySQL 8.0 ou superieur
- Composer

## Installation Rapide

```bash
git clone https://github.com/Katsuexe/projet-regime.git
cd projet-regime/src
php composer.phar install
cp env .env
# Editer .env avec vos parametres de base de donnees
php spark migrate
php spark db:seed UserSeeder
php spark db:seed RegimeSeeder
php spark db:seed ActiviteSeeder
php spark db:seed CodeSeeder
php spark serve
```

Les instructions detaillees sont disponibles dans [doc/installation.md](doc/installation.md).

## Documentation

- [Informations du projet](doc/project.md)
- [Fonctionnalites et guide d&#39;utilisation](doc/features.md)
- [Installation detaillee](doc/installation.md)
- [Schema base de donnees](doc/database.md)

## Securite

- Authentification : Sessions PHP avec hash securise
- Validation : Regles strictes sur tous les formulaires
- Protection XSS : Echappement automatique des vues
- CSRF : Protection activee sur les formulaires critiques
- Filtrage : Middleware pour acces admin/utilisateur

## Licence

Ce projet est sous licence MIT - voir le fichier [LICENSE](LICENSE) pour plus de details.
