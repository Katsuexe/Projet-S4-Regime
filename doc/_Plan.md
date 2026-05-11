# Plan détaillé — Projet S4 : Application Régime Alimentaire
> CodeIgniter 4 · PHP 8 · MySQL · Bootstrap · Chart.js · jsPDF  
> Rendu : **lundi 11 mai 2026** · Groupe de 3

---

## 1. Arborescence des fichiers

```
projet-regime/
│
├── app/
│   ├── Config/
│   │   ├── App.php
│   │   ├── Database.php
│   │   ├── Routes.php              ← toutes les routes front + back
│   │   └── Filters.php             ← middleware auth session
│   │
│   ├── Controllers/
│   │   ├── BaseController.php
│   │   ├── Auth/
│   │   │   ├── RegisterStep1.php   ← infos perso (nom, email, genre)
│   │   │   ├── RegisterStep2.php   ← infos santé (taille, poids)
│   │   │   └── LoginController.php
│   │   ├── Front/
│   │   │   ├── HomeController.php
│   │   │   ├── ProfilController.php
│   │   │   ├── RegimeController.php
│   │   │   ├── PorteMonnaieController.php
│   │   │   └── PdfController.php   ← export PDF
│   │   └── Admin/
│   │       ├── DashboardController.php
│   │       ├── RegimeAdminController.php
│   │       ├── ActiviteAdminController.php
│   │       ├── CodeAdminController.php
│   │       └── ParametreController.php
│   │
│   ├── Models/
│   │   ├── UserModel.php
│   │   ├── UserSanteModel.php
│   │   ├── RegimeModel.php
│   │   ├── RegimeDureeModel.php    ← prix selon durée
│   │   ├── ActiviteModel.php
│   │   ├── CodeModel.php
│   │   ├── UserRegimeModel.php     ← pivot
│   │   └── ParametreModel.php
│   │
│   ├── Views/
│   │   ├── layouts/
│   │   │   ├── front.php           ← layout utilisateur
│   │   │   └── admin.php           ← layout admin
│   │   ├── partials/
│   │   │   ├── navbar_front.php
│   │   │   ├── navbar_admin.php
│   │   │   └── flash_messages.php
│   │   ├── auth/
│   │   │   ├── login.php
│   │   │   ├── register_step1.php
│   │   │   └── register_step2.php
│   │   ├── front/
│   │   │   ├── home.php
│   │   │   ├── profil.php
│   │   │   ├── objectif.php
│   │   │   ├── suggestions.php
│   │   │   └── porte_monnaie.php
│   │   └── admin/
│   │       ├── dashboard.php
│   │       ├── regimes/
│   │       │   ├── index.php
│   │       │   ├── create.php
│   │       │   └── edit.php
│   │       ├── activites/
│   │       │   ├── index.php
│   │       │   ├── create.php
│   │       │   └── edit.php
│   │       ├── codes/
│   │       │   ├── index.php
│   │       │   └── create.php
│   │       └── parametres/
│   │           └── index.php
│   │
│   ├── Filters/
│   │   ├── AuthFilter.php          ← protège les routes front
│   │   └── AdminFilter.php         ← protège les routes /admin
│   │
│   └── Libraries/
│       ├── ImcCalculator.php       ← calcul IMC + catégorie
│       └── RegimeSuggestor.php     ← logique de suggestion
│
├── public/
│   ├── index.php
│   ├── css/
│   │   ├── app.css                 ← variables couleurs + surcharge Bootstrap
│   │   └── admin.css
│   ├── js/
│   │   ├── imc.js                  ← calcul AJAX IMC live
│   │   ├── porte_monnaie.js        ← validation code AJAX
│   │   └── charts.js               ← Chart.js dashboard
│   └── assets/
│       └── logo.svg
│
├── database/
│   ├── migrations/
│   │   ├── 2024-01-01-000001_CreateUsersTable.php
│   │   ├── 2024-01-01-000002_CreateRegimesTable.php
│   │   ├── 2024-01-01-000003_CreateActivitesTable.php
│   │   ├── 2024-01-01-000004_CreateCodesTable.php
│   │   └── 2024-01-01-000005_CreateUserRegimesTable.php
│   └── seeds/
│       ├── UserSeeder.php          ← 5 utilisateurs
│       ├── RegimeSeeder.php        ← 5 régimes
│       ├── ActiviteSeeder.php      ← 5 activités
│       └── CodeSeeder.php          ← 15 codes
│
├── script.sql                      ← export SQL final pour livraison
├── .env
├── .gitignore
├── composer.json
└── README.md
```

---

## 2. Base de données — Schéma SQL

```sql
-- ─── UTILISATEURS ────────────────────────────────────────────
CREATE TABLE users (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    nom        VARCHAR(100) NOT NULL,
    prenom     VARCHAR(100) NOT NULL,
    email      VARCHAR(150) NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,
    genre      ENUM('homme','femme') NOT NULL,
    is_gold    TINYINT(1) DEFAULT 0,
    solde      DECIMAL(10,2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE user_sante (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    user_id    INT NOT NULL,
    taille     DECIMAL(5,2) NOT NULL,   -- en cm
    poids      DECIMAL(5,2) NOT NULL,   -- en kg
    objectif   ENUM('augmenter','reduire','ideal') NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- ─── RÉGIMES ─────────────────────────────────────────────────
CREATE TABLE regimes (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    nom             VARCHAR(150) NOT NULL,
    description     TEXT,
    pct_viande      DECIMAL(5,2) NOT NULL,  -- % viande
    pct_poisson     DECIMAL(5,2) NOT NULL,  -- % poisson
    pct_volaille    DECIMAL(5,2) NOT NULL,  -- % volaille
    delta_poids_min DECIMAL(4,2),           -- variation poids min (kg)
    delta_poids_max DECIMAL(4,2),           -- variation poids max (kg)
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE regime_durees (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    regime_id  INT NOT NULL,
    duree_jours INT NOT NULL,              -- ex: 7, 14, 30, 60
    prix       DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (regime_id) REFERENCES regimes(id) ON DELETE CASCADE
);

-- ─── ACTIVITÉS SPORTIVES ─────────────────────────────────────
CREATE TABLE activites (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nom         VARCHAR(150) NOT NULL,
    description TEXT,
    calories_h  INT,           -- calories brûlées / heure
    duree_min   INT,           -- durée recommandée en minutes/jour
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ─── CODES PORTEFEUILLE ──────────────────────────────────────
CREATE TABLE codes (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    code        VARCHAR(50) NOT NULL UNIQUE,
    montant     DECIMAL(10,2) NOT NULL,
    is_used     TINYINT(1) DEFAULT 0,
    used_by     INT DEFAULT NULL,
    used_at     TIMESTAMP NULL,
    FOREIGN KEY (used_by) REFERENCES users(id)
);

-- ─── ACHATS RÉGIMES ──────────────────────────────────────────
CREATE TABLE user_regimes (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    user_id         INT NOT NULL,
    regime_id       INT NOT NULL,
    regime_duree_id INT NOT NULL,
    activite_id     INT,
    prix_paye       DECIMAL(10,2) NOT NULL,
    gold_remise     TINYINT(1) DEFAULT 0,
    date_debut      DATE,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id)         REFERENCES users(id),
    FOREIGN KEY (regime_id)       REFERENCES regimes(id),
    FOREIGN KEY (regime_duree_id) REFERENCES regime_durees(id),
    FOREIGN KEY (activite_id)     REFERENCES activites(id)
);

-- ─── PARAMÈTRES ──────────────────────────────────────────────
CREATE TABLE parametres (
    id    INT AUTO_INCREMENT PRIMARY KEY,
    cle   VARCHAR(100) NOT NULL UNIQUE,
    valeur TEXT NOT NULL
);
-- ex: prix_gold = '29.99', imc_ideal_min = '18.5', imc_ideal_max = '24.9'
```

---

## 3. Routes — `app/Config/Routes.php`

```php
<?php
// ─── FRONT ───────────────────────────────────────────────────
$routes->get('/', 'Front\HomeController::index');

// Auth (sans filtre)
$routes->get('inscription/etape1',  'Auth\RegisterStep1::index');
$routes->post('inscription/etape1', 'Auth\RegisterStep1::store');
$routes->get('inscription/etape2',  'Auth\RegisterStep2::index');
$routes->post('inscription/etape2', 'Auth\RegisterStep2::store');
$routes->get('connexion',  'Auth\LoginController::index');
$routes->post('connexion', 'Auth\LoginController::login');
$routes->get('deconnexion','Auth\LoginController::logout');

// Espace utilisateur (filtre auth requis)
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('profil',           'Front\ProfilController::index');
    $routes->post('profil',          'Front\ProfilController::update');
    $routes->get('objectif',         'Front\RegimeController::objectif');
    $routes->post('objectif',        'Front\RegimeController::choisir');
    $routes->get('suggestions',      'Front\RegimeController::suggestions');
    $routes->post('souscrire/(:num)','Front\RegimeController::souscrire/$1');
    $routes->get('export-pdf/(:num)','Front\PdfController::export/$1');
    $routes->get('portefeuille',     'Front\PorteMonnaieController::index');
    $routes->post('code/valider',    'Front\PorteMonnaieController::valider');
    $routes->post('gold/activer',    'Front\PorteMonnaieController::activerGold');
});

// AJAX
$routes->post('ajax/imc',  'Front\ProfilController::calculerImc');
$routes->post('ajax/code', 'Front\PorteMonnaieController::validerAjax');

// ─── BACK OFFICE ─────────────────────────────────────────────
$routes->group('admin', ['filter' => 'admin'], function($routes) {
    $routes->get('/',              'Admin\DashboardController::index');
    $routes->resource('regimes',   ['controller' => 'Admin\RegimeAdminController']);
    $routes->resource('activites', ['controller' => 'Admin\ActiviteAdminController']);
    $routes->get('codes',          'Admin\CodeAdminController::index');
    $routes->post('codes/create',  'Admin\CodeAdminController::create');
    $routes->post('codes/valider', 'Admin\CodeAdminController::valider');
    $routes->get('parametres',     'Admin\ParametreController::index');
    $routes->post('parametres',    'Admin\ParametreController::update');
});
```

---

## 4. Calcul IMC — `app/Libraries/ImcCalculator.php`

```php
<?php
namespace App\Libraries;

class ImcCalculator
{
    public static function calculate(float $poidsKg, float $tailleCm): float
    {
        $tailleM = $tailleCm / 100;
        return round($poidsKg / ($tailleM ** 2), 2);
    }

    public static function categorie(float $imc): string
    {
        return match(true) {
            $imc < 18.5 => 'Insuffisance pondérale',
            $imc < 25.0 => 'Poids normal',
            $imc < 30.0 => 'Surpoids',
            default     => 'Obésité',
        };
    }

    public static function imcIdeal(string $genre, float $tailleCm): array
    {
        // Formule Lorentz
        if ($genre === 'homme') {
            $ideal = $tailleCm - 100 - (($tailleCm - 150) / 4);
        } else {
            $ideal = $tailleCm - 100 - (($tailleCm - 150) / 2.5);
        }
        $tailleM = $tailleCm / 100;
        return [
            'poids_ideal' => round($ideal, 1),
            'imc_min'     => round(18.5 * $tailleM ** 2, 1),
            'imc_max'     => round(24.9 * $tailleM ** 2, 1),
        ];
    }
}
```

---

## 5. Logique Gold & Remise — `app/Libraries/RegimeSuggestor.php`

```php
<?php
namespace App\Libraries;

use App\Models\RegimeModel;
use App\Models\ActiviteModel;

class RegimeSuggestor
{
    const REMISE_GOLD = 0.15; // 15%

    public static function suggerer(string $objectif, float $imc): array
    {
        $regimeModel = new RegimeModel();
        $activiteModel = new ActiviteModel();

        $regimes = match($objectif) {
            'augmenter' => $regimeModel->where('delta_poids_min >', 0)->findAll(),
            'reduire'   => $regimeModel->where('delta_poids_max <', 0)->findAll(),
            default     => $regimeModel->findAll(),
        };

        $activites = $activiteModel->findAll();

        return compact('regimes', 'activites');
    }

    public static function appliquerRemise(float $prix, bool $isGold): float
    {
        return $isGold ? round($prix * (1 - self::REMISE_GOLD), 2) : $prix;
    }
}
```

---

## 6. Filtre Authentification — `app/Filters/AuthFilter.php`

```php
<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session()->get('user_id')) {
            return redirect()->to('/connexion')->with('error', 'Connectez-vous d\'abord.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
```

---

## 7. Inscription en 2 étapes

### Étape 1 — `RegisterStep1.php`

```php
public function store()
{
    $rules = [
        'nom'    => 'required|min_length[2]',
        'prenom' => 'required|min_length[2]',
        'email'  => 'required|valid_email|is_unique[users.email]',
        'genre'  => 'required|in_list[homme,femme]',
        'password'        => 'required|min_length[8]',
        'password_confirm' => 'required|matches[password]',
    ];

    if (! $this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    // Stocker temporairement en session
    session()->set('register_step1', $this->request->getPost());
    return redirect()->to('/inscription/etape2');
}
```

### Étape 2 — `RegisterStep2.php`

```php
public function store()
{
    $step1 = session()->get('register_step1');
    if (! $step1) return redirect()->to('/inscription/etape1');

    $rules = [
        'taille'  => 'required|numeric|greater_than[100]|less_than[250]',
        'poids'   => 'required|numeric|greater_than[30]|less_than[300]',
        'objectif'=> 'required|in_list[augmenter,reduire,ideal]',
    ];

    if (! $this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    // Créer l'utilisateur
    $userModel = new \App\Models\UserModel();
    $userId = $userModel->insert([
        'nom'      => $step1['nom'],
        'prenom'   => $step1['prenom'],
        'email'    => $step1['email'],
        'password' => password_hash($step1['password'], PASSWORD_DEFAULT),
        'genre'    => $step1['genre'],
    ]);

    // Créer la fiche santé
    $santeModel = new \App\Models\UserSanteModel();
    $santeModel->insert([
        'user_id'  => $userId,
        'taille'   => $this->request->getPost('taille'),
        'poids'    => $this->request->getPost('poids'),
        'objectif' => $this->request->getPost('objectif'),
    ]);

    session()->remove('register_step1');
    session()->set('user_id', $userId);
    return redirect()->to('/suggestions');
}
```

---

## 8. AJAX — Calcul IMC live — `public/js/imc.js`

```javascript
const taille = document.getElementById('taille');
const poids  = document.getElementById('poids');
const imcBox = document.getElementById('imc-result');

function calculerImc() {
    const t = parseFloat(taille.value);
    const p = parseFloat(poids.value);
    if (!t || !p) return;

    fetch('/ajax/imc', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        body: JSON.stringify({ taille: t, poids: p })
    })
    .then(r => r.json())
    .then(data => {
        imcBox.innerHTML = `
          <strong>${data.imc}</strong>
          <span class="badge bg-${data.couleur}">${data.categorie}</span>
          <small>Poids idéal estimé : ${data.poids_ideal} kg</small>
        `;
    });
}

[taille, poids].forEach(el => el.addEventListener('input', calculerImc));
```

```php
// ProfilController::calculerImc()
public function calculerImc()
{
    $data = $this->request->getJSON(true);
    $imc  = ImcCalculator::calculate($data['poids'], $data['taille']);
    $cat  = ImcCalculator::categorie($imc);
    $ideal = ImcCalculator::imcIdeal(session()->get('genre'), $data['taille']);

    return $this->response->setJSON([
        'imc'         => $imc,
        'categorie'   => $cat,
        'couleur'     => $imc < 18.5 || $imc >= 30 ? 'danger' : ($imc < 25 ? 'success' : 'warning'),
        'poids_ideal' => $ideal['poids_ideal'],
    ]);
}
```

---

## 9. Export PDF — `app/Controllers/Front/PdfController.php`

```php
// Utilise dompdf (composer require dompdf/dompdf)
public function export(int $userRegimeId)
{
    $data = $this->userRegimeModel->getFullData($userRegimeId);
    $html = view('front/pdf_template', $data);

    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream('mon-regime.pdf', ['Attachment' => true]);
}
```

---

## 10. Dashboard Admin — Graphes `public/js/charts.js`

```javascript
// Chart.js — répartition des régimes achetés
fetch('/admin/stats/json')
  .then(r => r.json())
  .then(data => {

    // Doughnut — objectifs utilisateurs
    new Chart(document.getElementById('chartObjectifs'), {
      type: 'doughnut',
      data: {
        labels: ['Augmenter', 'Réduire', 'IMC idéal'],
        datasets: [{ data: data.objectifs, backgroundColor: ['#198754','#dc3545','#0d6efd'] }]
      }
    });

    // Bar — régimes les plus souscrits
    new Chart(document.getElementById('chartRegimes'), {
      type: 'bar',
      data: {
        labels: data.regimes.map(r => r.nom),
        datasets: [{ label: 'Souscriptions', data: data.regimes.map(r => r.count) }]
      }
    });

    // Line — nouveaux inscrits par mois
    new Chart(document.getElementById('chartInscrits'), {
      type: 'line',
      data: {
        labels: data.mois,
        datasets: [{ label: 'Inscriptions', data: data.inscrits, tension: 0.4, fill: true }]
      }
    });
  });
```

---

## 11. Portefeuille — Validation code AJAX

```javascript
// public/js/porte_monnaie.js
document.getElementById('btn-valider').addEventListener('click', () => {
    const code = document.getElementById('code-input').value.trim();

    fetch('/ajax/code', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        body: JSON.stringify({ code })
    })
    .then(r => r.json())
    .then(data => {
        const el = document.getElementById('code-result');
        if (data.success) {
            el.className = 'alert alert-success';
            el.textContent = `+${data.montant} € ajoutés. Solde : ${data.solde} €`;
        } else {
            el.className = 'alert alert-danger';
            el.textContent = data.message;
        }
    });
});
```

---

## 12. Seeds — Données minimales

```php
// database/seeds/RegimeSeeder.php
class RegimeSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nom'=>'Méditerranéen', 'pct_viande'=>20,'pct_poisson'=>40,'pct_volaille'=>40,'delta_poids_min'=>-0.5,'delta_poids_max'=>0.2],
            ['nom'=>'Hyperprotéiné', 'pct_viande'=>50,'pct_poisson'=>20,'pct_volaille'=>30,'delta_poids_min'=>0.3,'delta_poids_max'=>1.0],
            ['nom'=>'Hypocalorique', 'pct_viande'=>15,'pct_poisson'=>35,'pct_volaille'=>50,'delta_poids_min'=>-1.5,'delta_poids_max'=>-0.3],
            ['nom'=>'Cétogène',      'pct_viande'=>60,'pct_poisson'=>10,'pct_volaille'=>30,'delta_poids_min'=>-2.0,'delta_poids_max'=>-0.5],
            ['nom'=>'Végétarien+',   'pct_viande'=>0, 'pct_poisson'=>30,'pct_volaille'=>0, 'delta_poids_min'=>-0.8,'delta_poids_max'=>0.1],
        ];
        $this->db->table('regimes')->insertBatch($data);
    }
}
```

---

## 13. Récapitulatif des fonctionnalités & avancement

| Fonctionnalité | Module | Priorité | Notes | Responsable |
|---|---|---|---|---|
| Inscription 2 étapes | Auth | 🔴 Critique | Session entre étapes | Katsu |
| Login / Logout | Auth | 🔴 Critique | password_hash | Katsu |
| Calcul IMC live | Profil | 🔴 Critique | AJAX + PHP | Katsu |
| Choix objectif | Front | 🔴 Critique | 3 options | IVO |
| Suggestions régime | Front | 🔴 Critique | Logique métier | IVO |
| Export PDF | Front | 🟠 Important | dompdf | Katsu |
| Portefeuille + codes | Front | 🟠 Important | AJAX | Katsu |
| Option Gold 15% | Front | 🟠 Important | flag is_gold | Katsu |
| CRUD Régimes | Admin | 🔴 Critique | % viande/poisson | IVO |
| Prix par durée | Admin | 🔴 Critique | table regime_durees | Katsu |
| CRUD Activités | Admin | 🟠 Important |  | Karen |
| Validation codes | Admin | 🟠 Important |  | Katsu (lead), Karen (support) |
| Dashboard stats | Admin | 🟡 Bonus | Chart.js | Katsu (lead), Karen (support) |
| CRUD Paramètres | Admin | 🟡 Bonus | clé/valeur | IVO |

---

## 14. Checklist livraison

- [ ] Code source pushé sur GitLab/GitHub (branche `main` à jour)
- [ ] Merge Request effectué dans `main`
- [ ] Commits réguliers tout au long du projet
- [ ] `script.sql` exporté et testé
- [ ] Formulaire Google Forms rempli
- [ ] Liste membres groupe fournie
- [ ] Google Sheet suivi des tâches à jour
- [ ] 5 utilisateurs · 15 codes · 5 régimes · 5 activités en base
- [ ] README avec instructions d'installation

---

## 15. Installation rapide

```bash
# Cloner et installer
git clone https://github.com/votre-repo/projet-regime.git
cd projet-regime
composer install

# Configurer l'environnement
cp env .env
# Éditer .env : CI_ENVIRONMENT, database.*

# Migrations + seeds
php spark migrate
php spark db:seed DatabaseSeeder

# Lancer le serveur
php spark serve
```

## 16. Personnaliser la route cachée (Admin / Coach)

Pour plus de sécurité, les pages de connexion pour les comptes `admin` et `coach` sont exposées via des routes "cachées" configurables. Ces routes sont lues depuis `Config\\AuthGroups` et peuvent être définies dans le fichier `.env`.

Exemple à ajouter dans `.env` :

```env
auth.hiddenAdminRoute=espace-securise/mon-admin-secret/connexion
auth.hiddenCoachRoute=espace-securise/mon-coach-secret/connexion
```

Après modification, redémarrez le serveur (`php spark serve`) ou videz le cache si nécessaire : `php spark cache:clear`.

Voir également `src/app/Config/AuthGroups.php` pour les valeurs par défaut.
