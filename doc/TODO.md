# Checklist complète — Projet S4 : Régime Alimentaire

> Légende : 🔴 Bloquant · 🟠 Important · 🟡 Bonus · ☐ À faire · ☑ Fait

---

### A. Initialisation & environnement

* [X] 🔴 Créer le dépôt GitHub / GitLab (nom du repo clair)
* [X] 🔴 Ajouter les 3 membres comme collaborateurs
* [X] 🔴 Créer le `.gitignore` (`.env`, `vendor/`, `writable/`, `*.log`)
* [X] 🔴 Copier `env` → `.env` et configurer `DB_*`, `CI_ENVIRONMENT = development`
* [X] 🔴 Installer CodeIgniter 4 via Composer (`composer create-project`)
* [X] 🔴 Vérifier que `php spark serve` fonctionne
* [ ] 🟠 Créer la branche `dev` pour le développement, `main` = branche de livraison
* [ ] 🟠 Créer le Google Sheet de suivi des tâches avec colonnes : Tâche / Responsable / Statut / Date
* [X] 🟠 Rédiger le `README.md` (installation, membres, description)

---

### B. Base de données

* [X] 🔴 Créer la base MySQL (`regime_s4` ou autre nom)
* [X] 🔴 Écrire la migration `users`
* [X] 🔴 Écrire la migration `user_sante`
* [X] 🔴 Écrire la migration `regimes`
* [X] 🔴 Écrire la migration `regime_durees` (prix selon durée)
* [X] 🔴 Écrire la migration `activites`
* [X] 🔴 Écrire la migration `codes`
* [X] 🔴 Écrire la migration `user_regimes` (pivot achats)
* [X] 🟠 Écrire la migration `parametres` (clé/valeur) — table présente dans `les script.sql` mais pas de fichier migration CI4 dédié
* [X] 🔴 Lancer `php spark migrate` sans erreur
* [X] 🔴 Seed : 5 utilisateurs (genres mixtes, mots de passe hashés) — `UserSeeder.php` rempli
* [X] 🔴 Seed : 5 régimes (avec % viande / poisson / volaille remplis) — `RegimeSeeder.php` rempli
* [X] 🔴 Seed : prix pour chaque régime (au moins 3 durées différentes par régime) — seedé via `RegimeSeeder.php`
* [X] 🔴 Seed : 5 activités sportives (avec calories/h et durée recommandée) — `ActiviteSeeder.php` rempli
* [X] 🔴 Seed : 15 codes portefeuille (montants variés, tous `is_used = 0`) — `CodeSeeder.php` rempli
* [X] 🟠 Seed : paramètres (prix Gold, IMC min/max idéal) — `ParametreSeeder.php` ajouté
* [X] 🔴 Exporter `script.sql` final et le versionner

---

### C. Authentification

* [X] 🔴 `AuthFilter.php` — redirige vers `/connexion` si pas de session `user_id`
* [X] 🔴 `AdminFilter.php` — redirige vers `/admin` si pas de session `admin_id`
* [X] 🔴 Enregistrer les filtres dans `app/Config/Filters.php`
* [X] 🔴 Page login utilisateur (formulaire email + mot de passe)
* [X] 🔴 Vérification `password_verify()` au login
* [X] 🔴 Stockage session `user_id`, `nom`, `genre`, `is_gold`, `solde`
* [X] 🔴 Déconnexion (`session()->destroy()`)
* [X] 🔴 Page login admin séparée (`/admin/login`) — route cachée configurée via `AuthGroups`
* [X] 🟠 Message flash d'erreur si mauvais identifiants
* [X] 🟠 Redirection vers page d'origine après login (si accès refusé)

---

### D. Inscription en 2 étapes

* [X] 🔴 Étape 1 — Champs : nom, prénom, email, genre, mot de passe, confirmation
* [X] 🔴 Étape 1 — Validation CI4 (email unique, longueur, correspondance passwords)
* [X] 🔴 Étape 1 — Stockage des données en session (`register_step1`)
* [X] 🔴 Étape 2 — Champs : taille (cm), poids (kg), objectif (3 choix radio)
* [X] 🔴 Étape 2 — Validation CI4 (numérique, plages cohérentes)
* [X] 🔴 Étape 2 — Insertion dans `users` + `user_sante` en transaction
* [X] 🔴 Nettoyage session `register_step1` après succès
* [X] 🟠 Barre de progression visuelle entre les 2 étapes (Step 1/2)
* [X] 🟠 Redirection vers `/suggestions` après inscription réussie
* [X] 🔴 Vues d'inscription — `register_step1.php` et `register_step2.php`

---

### E. Profil utilisateur

* [X] 🔴 Page profil affichant toutes les infos (nom, email, genre, taille, poids) — contrôleur complet
* [X] 🔴 Affichage de l'IMC calculé et de sa catégorie (badge coloré) — logique présente
* [X] 🔴 Affichage du poids idéal estimé — via `ImcCalculator::imcIdeal()`
* [X] 🔴 Formulaire de modification du profil (taille, poids, objectif)
* [X] 🔴 Mise à jour en base après validation
* [X] 🟠 Affichage du solde portefeuille et du statut Gold — données passées à la vue
* [X] 🟠 Historique des régimes souscrits — récupéré et enrichi dans le contrôleur
* [X] 🔴 Vue profil — `front/profil.php`

---

### F. Calcul IMC live (AJAX)

* [X] 🔴 Route POST `/ajax/imc` sans filtre auth (accessible depuis l'inscription)
* [X] 🔴 Controller `calculerImc()` retourne JSON : imc, catégorie, couleur, poids idéal
* [X] 🔴 `imc.js` — écoute les inputs taille/poids, appel fetch, mise à jour DOM
* [X] 🟠 Animation / transition sur le badge IMC lors du recalcul
* [X] 🟠 Affichage de la fourchette IMC idéale (18.5 – 24.9)

---

### G. Objectif & Suggestions de régimes

* [X] 🔴 Page choix d'objectif (3 cartes cliquables : augmenter / réduire / idéal) — contrôleur OK
* [X] 🔴 Sauvegarde de l'objectif en base (`user_sante.objectif`)
* [X] 🔴 Page suggestions filtre les régimes selon l'objectif et l'IMC actuel
* [X] 🔴 Affichage des régimes : nom, description, % composition (viande/poisson/volaille)
* [X] 🔴 Affichage des durées disponibles avec le prix correspondant
* [X] 🔴 Affichage de la remise Gold (15%) si `is_gold = 1` (prix barré + prix réduit) — logique dans `RegimeSuggestor`
* [X] 🔴 Affichage des activités sportives suggérées — passées à la vue
* [X] 🔴 Bouton "Souscrire" pour chaque régime + durée — route POST `/souscrire`
* [X] 🔴 Vérification du solde suffisant avant souscription
* [X] 🔴 Déduction du prix du solde + insertion dans `user_regimes`
* [X] 🟠 Indication de la variation de poids attendue par durée
* [X] 🔴 Vues suggestions et objectif — `front/suggestions.php` et `front/objectif.php`

---

### H. Export PDF

* [X] 🔴 Installer dompdf (`composer require dompdf/dompdf`)
* [X] 🔴 Vue `pdf_template.php` avec récapitulatif du régime
* [X] 🔴 Affichage de l'IMC de l'utilisateur et de l'objectif
* [X] 🔴 Route `/export-pdf/{id}` protégée par filtre auth
* [X] 🔴 Vérifier que l'utilisateur ne peut exporter que ses propres régimes
* [X] 🔴 `PdfController.php` — logique d'export implémentée
* [X] 🟠 Logo et mise en page propre dans le PDF
* [X] 🟠 Date de génération du PDF

---

### I. Portefeuille & codes

* [X] 🔴 Page portefeuille — contrôleur `PorteMonnaieController::index()` présent
* [X] 🔴 Formulaire saisie de code (champ texte + bouton) — logique côté serveur complète
* [X] 🔴 Route POST `/ajax/code` — vérification du code en base
* [X] 🔴 Si valide et non utilisé : créditer le solde, marquer `is_used = 1`, `used_by`, `used_at`
* [X] 🔴 Retour JSON : succès/erreur, montant ajouté, nouveau solde
* [X] 🔴 `porte_monnaie.js` — affichage dynamique implémenté
* [X] 🟠 Message d'erreur si code déjà utilisé ou inexistant — affiché côté front via JS
* [X] 🟠 Historique des codes utilisés par l'utilisateur
* [X] 🔴 Vue portefeuille — `front/porte_monnaie.php`

---

### J. Option Gold

* [X] 🔴 Définir le prix Gold dans les paramètres — lu depuis table `parametres`
* [X] 🔴 Page ou section "Passer Gold" — route POST `/ajax/gold` fonctionnelle
* [X] 🔴 Paiement depuis le solde portefeuille (vérifier solde suffisant)
* [X] 🔴 Mise à jour `users.is_gold = 1` après paiement
* [X] 🔴 Application automatique de la remise 15% sur toutes les suggestions
* [X] 🟠 Badge "Gold" visible sur le profil et la navbar
* [X] 🟠 Affichage du prix avant/après remise (prix barré)

---

### K. Back Office — Dashboard admin

* [X] 🔴 Page d'authentification admin séparée (`/admin/login`)
* [X] 🔴 Tableau de bord avec au moins 3 statistiques chiffrées (nb users, nb souscriptions, revenus) — données calculées dans contrôleur
* [X] 🔴 Graphe 1 : répartition des objectifs utilisateurs (doughnut Chart.js) — données JSON prêtes
* [X] 🔴 Graphe 2 : régimes les plus souscrits (bar chart) — données JSON prêtes
* [X] 🟠 Graphe 3 : inscriptions par mois (line chart)
* [X] 🟠 Tableau croisé : objectif × régime choisi — requête SQL présente
* [X] 🟠 Indicateurs Gold : nb utilisateurs Gold, revenus Gold
* [X] 🔴 Vue dashboard — `admin/dashboard.php`

---

### K bis. Back Office — Coach (déprécié car non demandé)

* [ ] 🟠 Définir clairement le périmètre fonctionnel du rôle coach dans les specs
* [X] 🟠 Ajouter les routes coach dans `app/Config/Routes.php`
* [ ] 🟠 Finaliser le dashboard coach et ses accès — vue présente, périmètre encore à confirmer
* [X] 🟠 Vérifier la cohérence entre `users.role`, `CoachFilter` et `Config/AuthGroups`

---

### L. Back Office — CRUD Régimes

* [X] 🔴 Liste de tous les régimes (tableau avec pagination) — contrôleur OK
* [X] 🔴 Formulaire création : nom, description, % viande, % poisson, % volaille
* [X] 🔴 Validation : somme des % = 100 (contrôle PHP + JS) — contrôle PHP ajouté
* [X] 🔴 Champs delta poids min/max (variation attendue en kg)
* [X] 🔴 Section "Durées & Prix" dans le formulaire (ajouter N lignes dynamiquement) — logique batch insert côté serveur
* [X] 🔴 Modification d'un régime existant (pré-remplissage du formulaire)
* [X] 🔴 Suppression avec confirmation (vérifier qu'aucun user n'est dessus) — confirmation UI + blocage si déjà souscrit
* [ ] 🟠 Aperçu de la composition en graphe (pie chart inline)
* [X] 🔴 Vues CRUD régimes — `admin/regimes/index.php`, `create.php`, `edit.php`

---

### M. Back Office — CRUD Activités

* [X] 🔴 Liste des activités sportives — contrôleur présent
* [X] 🔴 Formulaire création/modification : nom, description, calories/h, durée recommandée (min/jour)
* [X] 🔴 Suppression avec confirmation
* [ ] 🟠 Association activité ↔ objectif (quelle activité pour quel objectif)
* [X] 🔴 Vues CRUD activités — `admin/activites/index.php`, `create.php`, `edit.php`

---

### N. Back Office — Codes portefeuille

* [X] 🔴 Liste de tous les codes (code, montant, statut utilisé/libre, utilisé par qui) — contrôleur présent
* [X] 🔴 Formulaire génération de code (montant + code unique auto ou manuel)
* [X] 🔴 Filtres : afficher uniquement les codes libres / utilisés
* [X] 🟠 Export CSV des codes générés
* [X] 🔴 Vues codes — `admin/codes/index.php` et `create.php`

---

### O. Back Office — Paramètres

* [X] 🟠 Page liste clé/valeur modifiable : prix Gold, IMC min/max idéal, % remise Gold — contrôleur présent
* [X] 🟠 Formulaire de modification (sans supprimer, juste `UPDATE`)
* [X] 🟠 Les valeurs sont lues dynamiquement dans l'application (pas hardcodées) — `PorteMonnaieController` lit depuis `parametres`
* [X] 🟠 Vue paramètres — `admin/parametres/index.php`

---

### P. Interface & UX

* [X] 🔴 Layout front distinct du layout admin
* [X] 🔴 Navbar front : logo, profil, portefeuille (solde), déconnexion
* [X] 🔴 Navbar admin : logo, liens modules, déconnexion
* [X] 🔴 Messages flash (succès / erreur) sur toutes les actions — partial centralisée et injectée aussi côté admin
* [X] 🔴 Pages d'erreur 403 / 404 personnalisées
* [X] 🟠 Responsive mobile (Bootstrap grid)
* [X] 🟠 Confirmation JavaScript avant toute suppression (`confirm()`)
* [X] 🟠 Indicateur de chargement sur les requêtes AJAX
* [X] 🟡 Transitions CSS entre les étapes d'inscription
* [X] 🟡 Favicon et titre de page dynamique (`<title>`)

---

### Q. Sécurité minimale

* [X] 🔴 Tous les mots de passe hashés avec `password_hash()` / `password_verify()`
* [X] 🔴 Token CSRF activé dans CI4 (`Config/Security.php` + `Filters.php` globals)
* [X] 🔴 Filtre auth sur toutes les routes `/profil`, `/suggestions`, `/export-pdf`, etc.
* [X] 🔴 Filtre admin sur toutes les routes `/admin/*`
* [X] 🔴 Vérification côté serveur que l'utilisateur ne modifie que ses propres données
* [X] 🟠 Validation de toutes les entrées avec les règles CI4 (auth + front controllers)
* [ ] 🟠 Échapper toutes les sorties dans les vues (`esc()` de CI4) — audit partiel avancé, corrections appliquées sur les vues touchées mais revue globale encore à terminer

---

### R. Git & collaboration

* [ ] 🔴 Premier commit : structure CI4 de base + `.gitignore`
* [ ] 🔴 Commits réguliers tout au long (pas seulement à la fin — critère noté)
* [ ] 🔴 Chaque membre fait ses propres commits (traçabilité individuelle)
* [ ] 🔴 Merge Request / Pull Request de `dev` → `main` avant livraison
* [X] 🔴 Branche `main` propre et fonctionnelle au moment de la livraison
* [ ] 🟠 Messages de commit clairs (ex: `feat: ajout calcul IMC AJAX`)
* [X] 🟠 Ne jamais push `.env` ni `vendor/`

---

### S. Livraison finale

* [X] 🔴 `script.sql` exporté, testé sur une base vierge, versionné dans le repo
* [X] 🔴 Données minimales présentes via seeds CI4 : 5 users · 5 régimes · 5 activités · 15 codes — seeders remplis (`DatabaseSeeder` ajouté)
* [ ] 🔴 Lien GitHub / GitLab fonctionnel et public (ou accessible au prof)
* [ ] 🔴 Formulaire Google Forms rempli avec le lien du repo
* [ ] 🔴 Liste des membres du groupe fournie
* [ ] 🔴 Google Sheet suivi des tâches à jour et partagé
* [X] 🔴 `README.md` avec instructions d'installation complètes
* [ ] 🟠 Tester l'installation depuis zéro sur une machine vierge avant de rendre

---

## Résumé de progression

| Section                   | Statut global                                                                  |
| ------------------------- | ------------------------------------------------------------------------------ |
| A. Init & environnement   | ✅ Quasi complet (Git/Sheet non vérifiable)                                   |
| B. Base de données       | ✅ Migrations OK · seeders CI4 présents · SQL complet                       |
| C. Authentification       | ✅ Login présent avec redirection post-auth                                   |
| D. Inscription 2 étapes  | ✅ Contrôleurs + vues + progression présents                                 |
| E. Profil utilisateur     | ✅ Contrôleur + vue profil présents                                          |
| F. IMC AJAX               | ✅ Route + endpoint + JS en place                                              |
| G. Suggestions & Objectif | ✅ Logique + vues présentes                                                   |
| H. Export PDF             | ✅ Export fonctionnel avec présentation jugée suffisante                     |
| I. Portefeuille & Codes   | ✅ Vue + JS présents · historique ajouté                                    |
| J. Option Gold            | ✅ Back-end + affichage principal présents                                    |
| K. Admin Dashboard        | ✅ Vue + indicateurs Gold + courbe mensuelle présents                         |
| L. CRUD Régimes          | ✅ Validation % + garde-fou suppression ajoutés                               |
| M. CRUD Activités        | ✅ Logique + vues présentes                                                   |
| N. Codes admin            | ✅ Filtres présents · export CSV ajouté                                     |
| O. Paramètres admin      | ✅ Logique + vue présentes                                                    |
| P. Interface & UX         | ✅ Base front/admin solide · responsive, loaders AJAX et transitions ajoutés |
| Q. Sécurité             | ✅ Majeure partie OK                                                           |
| S. Livraison              | ⚠️ SQL présent · Seeds CI4 prêts · Forms manquants                       |
