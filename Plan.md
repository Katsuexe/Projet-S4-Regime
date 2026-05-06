# Plan détaillé — Projet S4 : Application Régime Alimentaire

> CodeIgniter 4 · PHP 8 · MySQL · Bootstrap · Chart.js · jsPDF
> Rendu : **lundi 11 mai 2026** · Groupe de 3

---

## 1. Arborescence des fichiers

```
/
│
├── src/                           # Code source CodeIgniter 4
│   ├── app/
│   │   ├── Config/                # Configuration (Routes, Database, Filters)
│   │   ├── Controllers/           # Logique métier
│   │   │   ├── Auth/             # Inscription/Connexion
│   │   │   ├── Front/            # Espace utilisateur
│   │   │   └── Admin/            # Interface administration
│   │   ├── Models/               # Modèles de données
│   │   ├── Views/                # Templates PHP
│   │   ├── Filters/              # Middleware d'authentification
│   │   └── Libraries/            # Classes utilitaires (IMC, Suggestions)
│   ├── public/                   # Assets statiques (CSS, JS, images)
│   ├── database/                 # Migrations et seeds
│   ├── script.sql                # Export SQL final
│   └── composer.json             # Dépendances PHP
│
├── doc/                          # Documentation
│   ├── features.md               # Fonctionnalités et guide d'utilisation
│   ├── installation.md           # Installation détaillée
│   ├── database.md               # Schéma base de données
│   └── project.md                # Informations privées du projet
│
├── .env.example                  # Template configuration
├── .editorconfig                 # Règles d'édition
├── .gitattributes                # Règles Git
├── .gitignore                    # Fichiers ignorés
├── LICENSE                       # Licence MIT
├── README.md                     # Documentation principale
└── .vscode/                      # Configuration VS Code
    ├── launch.json
    └── tasks.json
```

---

## 2. Base de données — Schéma SQL

```sql
-- UTILISATEURS
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    genre ENUM('homme','femme') NOT NULL,
    is_gold TINYINT(1) DEFAULT 0,
    solde DECIMAL(10,2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE user_sante (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    taille DECIMAL(5,2) NOT NULL,
    poids DECIMAL(5,2) NOT NULL,
    objectif ENUM('augmenter','reduire','ideal') NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- REGIMES
CREATE TABLE regimes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    description TEXT,
    pct_viande DECIMAL(5,2) NOT NULL,
    pct_poisson DECIMAL(5,2) NOT NULL,
    pct_volaille DECIMAL(5,2) NOT NULL,
    delta_poids_min DECIMAL(4,2),
    delta_poids_max DECIMAL(4,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE regime_durees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    regime_id INT NOT NULL,
    duree_jours INT NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (regime_id) REFERENCES regimes(id) ON DELETE CASCADE
);

-- ACTIVITES SPORTIVES
CREATE TABLE activites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    description TEXT,
    calories_h INT,
    duree_min INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- CODES PORTEFEUILLE
CREATE TABLE codes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) NOT NULL UNIQUE,
    montant DECIMAL(10,2) NOT NULL,
    is_used TINYINT(1) DEFAULT 0,
    used_by INT DEFAULT NULL,
    used_at TIMESTAMP NULL,
    FOREIGN KEY (used_by) REFERENCES users(id)
);

-- ACHATS REGIMES
CREATE TABLE user_regimes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    regime_id INT NOT NULL,
    regime_duree_id INT NOT NULL,
    activite_id INT,
    prix_paye DECIMAL(10,2) NOT NULL,
    gold_remise TINYINT(1) DEFAULT 0,
    date_debut DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (regime_id) REFERENCES regimes(id),
    FOREIGN KEY (regime_duree_id) REFERENCES regime_durees(id),
    FOREIGN KEY (activite_id) REFERENCES activites(id)
);

-- PARAMETRES
CREATE TABLE parametres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cle VARCHAR(100) NOT NULL UNIQUE,
    valeur TEXT NOT NULL
);
```

---

## 3. Fonctionnalités principales

### Espace Utilisateur
- Inscription en 2 étapes (infos perso → données santé)
- Calcul IMC en temps réel avec AJAX
- Suggestions personnalisées selon objectif
- Portefeuille virtuel avec codes promo
- Option Gold (15% réduction)
- Export PDF des programmes
- Activités sportives complémentaires

### Administration
- CRUD complet pour régimes, activités, codes
- Dashboard avec graphiques Chart.js
- Gestion des paramètres système
- Validation et génération de codes promo

---

## 4. Technologies

- **Backend** : PHP 8.2+, CodeIgniter 4.5+
- **Base de données** : MySQL 8.0+
- **Frontend** : Bootstrap 5, JavaScript ES6+
- **Graphiques** : Chart.js
- **PDF** : jsPDF / DomPDF

---

## 5. Livrables

- Code source sur dépôt Git
- Base de données exportée (script.sql)
- Documentation complète
- Formulaire Google Forms rempli
- Suivi des tâches sur Google Sheet