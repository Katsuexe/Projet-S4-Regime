# Installation Detaillee

## 1. Clonage du depot
```bash
git clone https://github.com/votre-username/projet-regime.git
cd projet-regime/src
```

## 2. Installation des dependances
```bash
composer install
```

## 3. Configuration de l'environnement
```bash
# Copier le fichier d'exemple
cp env .env

# Editer .env avec vos parametres
nano .env  # ou votre editeur prefere
```

Variables essentielles a configurer :
```env
CI_ENVIRONMENT = development
app.baseURL = http://localhost:8080/

database.default.hostname = localhost
database.default.database = votre_base_donnees
database.default.username = votre_username
database.default.password = votre_password
database.default.DBDriver = MySQLi

# Generer une cle d'encryption securisee
app.encryptionKey = votre_cle_securisee_32_caracteres
```

## 4. Configuration de la base de donnees

Creer une base de donnees MySQL et executer les migrations :
```bash
# Creer la base de donnees
mysql -u root -p
CREATE DATABASE projet_regime CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;

# Lancer les migrations
php spark migrate

# Peupler avec des donnees d'exemple (optionnel)
php spark db:seed DatabaseSeeder
```

## 5. Demarrage du serveur
```bash
php spark serve
```

Acceder a l'application : http://localhost:8080