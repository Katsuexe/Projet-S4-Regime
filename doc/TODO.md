# Checklist complète — Projet S4 : Régime Alimentaire

> Légende : 🔴 Bloquant · 🟠 Important · 🟡 Bonus · ☐ À faire · ☑ Fait

---

### A. Initialisation & environnement

* [x] 🔴 Créer le dépôt GitHub / GitLab (nom du repo clair)
* [x] 🔴 Ajouter les 3 membres comme collaborateurs
* [x] 🔴 Créer le `.gitignore` (`.env`, `vendor/`, `writable/`, `*.log`)
* [x] 🔴 Copier `env` → `.env` et configurer `DB_*`, `CI_ENVIRONMENT = development`
* [x] 🔴 Installer CodeIgniter 4 via Composer (`composer create-project`)
* [x] 🔴 Vérifier que `php spark serve` fonctionne
* [ ] 🟠 Créer la branche `dev` pour le développement, `main` = branche de livraison
* [ ] 🟠 Créer le Google Sheet de suivi des tâches avec colonnes : Tâche / Responsable / Statut / Date
* [x] 🟠 Rédiger le `README.md` (installation, membres, description)

---

### B. Base de données

* [x] 🔴 Créer la base MySQL (`regime_s4` ou autre nom)
* [x] 🔴 Écrire la migration `users`
* [x] 🔴 Écrire la migration `user_sante`
* [x] 🔴 Écrire la migration `regimes`
* [x] 🔴 Écrire la migration `regime_durees` (prix selon durée)
* [x] 🔴 Écrire la migration `activites`
* [x] 🔴 Écrire la migration `codes`
* [x] 🔴 Écrire la migration `user_regimes` (pivot achats)
* [ ] 🟠 Écrire la migration `parametres` (clé/valeur) — table présente dans `script.sql` mais pas de fichier migration CI4 dédié
* [x] 🔴 Lancer `php spark migrate` sans erreur
* [ ] 🔴 Seed : 5 utilisateurs (genres mixtes, mots de passe hashés) — `UserSeeder.php` vide (données présentes dans `script.sql`)
* [ ] 🔴 Seed : 5 régimes (avec % viande / poisson / volaille remplis) — `RegimeSeeder.php` vide (données présentes dans `script.sql`)
* [ ] 🔴 Seed : prix pour chaque régime (au moins 3 durées différentes par régime) — non seedé via CI4
* [ ] 🔴 Seed : 5 activités sportives (avec calories/h et durée recommandée) — `ActiviteSeeder.php` vide (données présentes dans `script.sql`)
* [ ] 🔴 Seed : 15 codes portefeuille (montants variés, tous `is_used = 0`) — `CodeSeeder.php` vide (données présentes dans `script.sql`)
* [x] 🟠 Seed : paramètres (prix Gold, IMC min/max idéal) — présents dans `script.sql`
* [x] 🔴 Exporter `script.sql` final et le versionner

---

### C. Authentification

* [x] 🔴 `AuthFilter.php` — redirige vers `/connexion` si pas de session `user_id`
* [x] 🔴 `AdminFilter.php` — redirige vers `/admin` si pas de session `admin_id`
* [x] 🔴 Enregistrer les filtres dans `app/Config/Filters.php`
* [x] 🔴 Page login utilisateur (formulaire email + mot de passe)
* [x] 🔴 Vérification `password_verify()` au login
* [x] 🔴 Stockage session `user_id`, `nom`, `genre`, `is_gold`, `solde`
* [x] 🔴 Déconnexion (`session()->destroy()`)
* [x] 🔴 Page login admin séparée (`/admin/login`) — route cachée configurée via `AuthGroups`
* [x] 🟠 Message flash d'erreur si mauvais identifiants
* [ ] 🟠 Redirection vers page d'origine après login (si accès refusé)

---

### D. Inscription en 2 étapes

* [x] 🔴 Étape 1 — Champs : nom, prénom, email, genre, mot de passe, confirmation
* [x] 🔴 Étape 1 — Validation CI4 (email unique, longueur, correspondance passwords)
* [x] 🔴 Étape 1 — Stockage des données en session (`register_step1`)
* [x] 🔴 Étape 2 — Champs : taille (cm), poids (kg), objectif (3 choix radio)
* [x] 🔴 Étape 2 — Validation CI4 (numérique, plages cohérentes)
* [x] 🔴 Étape 2 — Insertion dans `users` + `user_sante` en transaction
* [x] 🔴 Nettoyage session `register_step1` après succès
* [x] 🟠 Barre de progression visuelle entre les 2 étapes (Step 1/2)
* [x] 🟠 Redirection vers `/suggestions` après inscription réussie
* [x] 🔴 Vues d'inscription — `register_step1.php` et `register_step2.php`

---

### E. Profil utilisateur

* [x] 🔴 Page profil affichant toutes les infos (nom, email, genre, taille, poids) — contrôleur complet
* [x] 🔴 Affichage de l'IMC calculé et de sa catégorie (badge coloré) — logique présente
* [x] 🔴 Affichage du poids idéal estimé — via `ImcCalculator::imcIdeal()`
* [x] 🔴 Formulaire de modification du profil (taille, poids, objectif)
* [x] 🔴 Mise à jour en base après validation
* [x] 🟠 Affichage du solde portefeuille et du statut Gold — données passées à la vue
* [x] 🟠 Historique des régimes souscrits — récupéré et enrichi dans le contrôleur
* [x] 🔴 Vue profil — `front/profil.php`

---

### F. Calcul IMC live (AJAX)

* [ ] 🔴 Route POST `/ajax/imc` sans filtre auth (accessible depuis l'inscription)
* [ ] 🔴 Controller `calculerImc()` retourne JSON : imc, catégorie, couleur, poids idéal
* [x] 🔴 `imc.js` — écoute les inputs taille/poids, appel fetch, mise à jour DOM
* [ ] 🟠 Animation / transition sur le badge IMC lors du recalcul
* [ ] 🟠 Affichage de la fourchette IMC idéale (18.5 – 24.9)

---

### G. Objectif & Suggestions de régimes

* [x] 🔴 Page choix d'objectif (3 cartes cliquables : augmenter / réduire / idéal) — contrôleur OK
* [x] 🔴 Sauvegarde de l'objectif en base (`user_sante.objectif`)
* [x] 🔴 Page suggestions filtre les régimes selon l'objectif et l'IMC actuel
* [x] 🔴 Affichage des régimes : nom, description, % composition (viande/poisson/volaille)
* [x] 🔴 Affichage des durées disponibles avec le prix correspondant
* [x] 🔴 Affichage de la remise Gold (15%) si `is_gold = 1` (prix barré + prix réduit) — logique dans `RegimeSuggestor`
* [x] 🔴 Affichage des activités sportives suggérées — passées à la vue
* [x] 🔴 Bouton "Souscrire" pour chaque régime + durée — route POST `/souscrire`
* [x] 🔴 Vérification du solde suffisant avant souscription
* [x] 🔴 Déduction du prix du solde + insertion dans `user_regimes`
* [x] 🟠 Indication de la variation de poids attendue par durée
* [x] 🔴 Vues suggestions et objectif — `front/suggestions.php` et `front/objectif.php`

---

### H. Export PDF

* [ ] 🔴 Installer dompdf (`composer require dompdf/dompdf`)
* [ ] 🔴 Vue `pdf_template.php` avec récapitulatif du régime — fichier vide
* [ ] 🔴 Affichage de l'IMC de l'utilisateur et de l'objectif
* [ ] 🔴 Route `/export-pdf/{id}` protégée par filtre auth — absent de `Routes.php`
* [ ] 🔴 Vérifier que l'utilisateur ne peut exporter que ses propres régimes
* [ ] 🔴 `PdfController.php` — fichier vide, aucune logique implémentée
* [ ] 🟠 Logo et mise en page propre dans le PDF
* [ ] 🟠 Date de génération du PDF

---

### I. Portefeuille & codes

* [x] 🔴 Page portefeuille — contrôleur `PorteMonnaieController::index()` présent
* [x] 🔴 Formulaire saisie de code (champ texte + bouton) — logique côté serveur complète
* [x] 🔴 Route POST `/ajax/code` — vérification du code en base
* [x] 🔴 Si valide et non utilisé : créditer le solde, marquer `is_used = 1`, `used_by`, `used_at`
* [x] 🔴 Retour JSON : succès/erreur, montant ajouté, nouveau solde
* [x] 🔴 `porte_monnaie.js` — affichage dynamique implémenté
* [x] 🟠 Message d'erreur si code déjà utilisé ou inexistant — affiché côté front via JS
* [ ] 🟠 Historique des codes utilisés par l'utilisateur
* [x] 🔴 Vue portefeuille — `front/porte_monnaie.php`

---

### J. Option Gold

* [x] 🔴 Définir le prix Gold dans les paramètres — lu depuis table `parametres`
* [x] 🔴 Page ou section "Passer Gold" — route POST `/ajax/gold` fonctionnelle
* [x] 🔴 Paiement depuis le solde portefeuille (vérifier solde suffisant)
* [x] 🔴 Mise à jour `users.is_gold = 1` après paiement
* [x] 🔴 Application automatique de la remise 15% sur toutes les suggestions
* [x] 🟠 Badge "Gold" visible sur le profil et la navbar
* [x] 🟠 Affichage du prix avant/après remise (prix barré)

---

### K. Back Office — Dashboard admin

* [x] 🔴 Page d'authentification admin séparée (`/admin/login`)
* [x] 🔴 Tableau de bord avec au moins 3 statistiques chiffrées (nb users, nb souscriptions, revenus) — données calculées dans contrôleur
* [x] 🔴 Graphe 1 : répartition des objectifs utilisateurs (doughnut Chart.js) — données JSON prêtes
* [x] 🔴 Graphe 2 : régimes les plus souscrits (bar chart) — données JSON prêtes
* [ ] 🟠 Graphe 3 : inscriptions par mois (line chart) — données `chart_souscriptions` par jour (7 jours), pas par mois
* [x] 🟠 Tableau croisé : objectif × régime choisi — requête SQL présente
* [ ] 🟠 Indicateurs Gold : nb utilisateurs Gold, revenus Gold — nb_gold présent, revenus Gold absent
* [x] 🔴 Vue dashboard — `admin/dashboard.php`

---

### K bis. Back Office — Coach

* [ ] 🟠 Définir clairement le périmètre fonctionnel du rôle coach dans les specs
* [x] 🟠 Ajouter les routes coach dans `app/Config/Routes.php`
* [ ] 🟠 Finaliser le dashboard coach et ses accès — vue présente, périmètre encore à confirmer
* [x] 🟠 Vérifier la cohérence entre `users.role`, `CoachFilter` et `Config/AuthGroups`

---

### L. Back Office — CRUD Régimes

* [x] 🔴 Liste de tous les régimes (tableau avec pagination) — contrôleur OK
* [x] 🔴 Formulaire création : nom, description, % viande, % poisson, % volaille
* [ ] 🔴 Validation : somme des % = 100 (contrôle PHP + JS) — aucune validation dans `RegimeAdminController::store()`
* [x] 🔴 Champs delta poids min/max (variation attendue en kg)
* [x] 🔴 Section "Durées & Prix" dans le formulaire (ajouter N lignes dynamiquement) — logique batch insert côté serveur
* [x] 🔴 Modification d'un régime existant (pré-remplissage du formulaire)
* [ ] 🔴 Suppression avec confirmation (vérifier qu'aucun user n'est dessus) — confirmation UI présente, vérification d'usage absente
* [ ] 🟠 Aperçu de la composition en graphe (pie chart inline)
* [x] 🔴 Vues CRUD régimes — `admin/regimes/index.php`, `create.php`, `edit.php`

---

### M. Back Office — CRUD Activités

* [x] 🔴 Liste des activités sportives — contrôleur présent
* [x] 🔴 Formulaire création/modification : nom, description, calories/h, durée recommandée (min/jour)
* [x] 🔴 Suppression avec confirmation
* [ ] 🟠 Association activité ↔ objectif (quelle activité pour quel objectif)
* [x] 🔴 Vues CRUD activités — `admin/activites/index.php`, `create.php`, `edit.php`

---

### N. Back Office — Codes portefeuille

* [x] 🔴 Liste de tous les codes (code, montant, statut utilisé/libre, utilisé par qui) — contrôleur présent
* [x] 🔴 Formulaire génération de code (montant + code unique auto ou manuel)
* [ ] 🔴 Filtres : afficher uniquement les codes libres / utilisés
* [ ] 🟠 Export CSV des codes générés
* [x] 🔴 Vues codes — `admin/codes/index.php` et `create.php`

---

### O. Back Office — Paramètres

* [x] 🟠 Page liste clé/valeur modifiable : prix Gold, IMC min/max idéal, % remise Gold — contrôleur présent
* [x] 🟠 Formulaire de modification (sans supprimer, juste `UPDATE`)
* [x] 🟠 Les valeurs sont lues dynamiquement dans l'application (pas hardcodées) — `PorteMonnaieController` lit depuis `parametres`
* [x] 🟠 Vue paramètres — `admin/parametres/index.php`

---

### P. Interface & UX

* [x] 🔴 Layout front distinct du layout admin
* [x] 🔴 Navbar front : logo, profil, portefeuille (solde), déconnexion
* [x] 🔴 Navbar admin : logo, liens modules, déconnexion
* [ ] 🔴 Messages flash (succès / erreur) sur toutes les actions — partial présente, couverture à uniformiser sur toutes les vues
* [ ] 🔴 Pages d'erreur 403 / 404 personnalisées — pages d'erreur à personnaliser
* [ ] 🟠 Responsive mobile (Bootstrap grid)
* [x] 🟠 Confirmation JavaScript avant toute suppression (`confirm()`)
* [ ] 🟠 Indicateur de chargement sur les requêtes AJAX
* [ ] 🟡 Transitions CSS entre les étapes d'inscription
* [x] 🟡 Favicon et titre de page dynamique (`<title>`)

---

### Q. Sécurité minimale

* [x] 🔴 Tous les mots de passe hashés avec `password_hash()` / `password_verify()`
* [x] 🔴 Token CSRF activé dans CI4 (`Config/Security.php` + `Filters.php` globals)
* [x] 🔴 Filtre auth sur toutes les routes `/profil`, `/suggestions`, `/export-pdf`, etc.
* [x] 🔴 Filtre admin sur toutes les routes `/admin/*`
* [x] 🔴 Vérification côté serveur que l'utilisateur ne modifie que ses propres données
* [x] 🟠 Validation de toutes les entrées avec les règles CI4 (auth + front controllers)
* [ ] 🟠 Échapper toutes les sorties dans les vues (`esc()` de CI4) — audit complet vue par vue encore à faire

---

### R. Git & collaboration

* [ ] 🔴 Premier commit : structure CI4 de base + `.gitignore`
* [ ] 🔴 Commits réguliers tout au long (pas seulement à la fin — critère noté)
* [ ] 🔴 Chaque membre fait ses propres commits (traçabilité individuelle)
* [ ] 🔴 Merge Request / Pull Request de `dev` → `main` avant livraison
* [ ] 🔴 Branche `main` propre et fonctionnelle au moment de la livraison
* [ ] 🟠 Messages de commit clairs (ex: `feat: ajout calcul IMC AJAX`)
* [x] 🟠 Ne jamais push `.env` ni `vendor/`

---

### S. Livraison finale

* [x] 🔴 `script.sql` exporté, testé sur une base vierge, versionné dans le repo
* [ ] 🔴 Données minimales présentes via seeds CI4 : 5 users · 5 régimes · 5 activités · 15 codes — tous les fichiers Seeder sont vides (données disponibles uniquement via `script.sql`)
* [ ] 🔴 Lien GitHub / GitLab fonctionnel et public (ou accessible au prof)
* [ ] 🔴 Formulaire Google Forms rempli avec le lien du repo
* [ ] 🔴 Liste des membres du groupe fournie
* [ ] 🔴 Google Sheet suivi des tâches à jour et partagé
* [x] 🔴 `README.md` avec instructions d'installation complètes
* [ ] 🟠 Tester l'installation depuis zéro sur une machine vierge avant de rendre

---

## Résumé de progression

| Section | Statut global |
|---|---|
| A. Init & environnement | ✅ Quasi complet (Git/Sheet non vérifiable) |
| B. Base de données | ⚠️ Migrations OK · Seeds vides · SQL complet |
| C. Authentification | ⚠️ Login présent · redirection post-auth à compléter |
| D. Inscription 2 étapes | ✅ Contrôleurs + vues + progression présents |
| E. Profil utilisateur | ✅ Contrôleur + vue profil présents |
| F. IMC AJAX | ⚠️ JS prêt · route et endpoint backend manquants |
| G. Suggestions & Objectif | ✅ Logique + vues présentes |
| H. Export PDF | ❌ Non démarré |
| I. Portefeuille & Codes | ⚠️ Vue + JS présents · historique manquant |
| J. Option Gold | ✅ Back-end + affichage principal présents |
| K. Admin Dashboard | ⚠️ Vue présente · certains indicateurs restent incomplets |
| L. CRUD Régimes | ⚠️ Vues présentes · validation % + garde-fou suppression manquants |
| M. CRUD Activités | ✅ Logique + vues présentes |
| N. Codes admin | ⚠️ Logique + vues présentes · filtres/export manquants |
| O. Paramètres admin | ✅ Logique + vue présentes |
| P. Interface & UX | ⚠️ Base front/admin en place · finitions UX encore incomplètes |
| Q. Sécurité | ✅ Majeure partie OK |
| R. Git | ⚠️ Non vérifiable depuis le zip |
| S. Livraison | ⚠️ SQL présent · Seeds CI4 vides · Forms manquants |
