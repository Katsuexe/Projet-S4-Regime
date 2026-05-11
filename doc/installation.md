# Installation Detaillee

## 1. Clonage du depot
```bash
git clone https://github.com/votre-username/projet-regime.git
cd projet-regime/src
```

## 2. Installation des dependances
```bash
php composer.phar install
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

## Personnaliser la route cachée (admin / coach)

L'application utilise des "routes cachées" pour l'accès administrateur et coach. Ces routes sont lues depuis la configuration `Config\AuthGroups` et peuvent être définies dans votre fichier `.env`.

Exemples à ajouter dans ` .env ` (sans slash initial) :

```env
auth.hiddenAdminRoute=espace-securise/portail-admin-9xk7/connexion
auth.hiddenCoachRoute=espace-securise/portail-coach-4mp2/connexion
```

Notes :
- La clé utilisée par le code est `auth.hiddenAdminRoute` et `auth.hiddenCoachRoute` (exactement comme ci‑dessus).
- Après modification du `.env`, redémarrez le serveur de développement (`php spark serve`) ou videz le cache si vous avez mis en cache la config :

```bash
php spark cache:clear
```

Les routes seront alors disponibles à l'URL que vous avez choisie (par exemple `/espace-securise/portail-admin-9xk7/connexion`).