# Checklist complète — Projet S4 : Régime Alimentaire

> Légende : 🔴 Bloquant · 🟠 Important · 🟡 Bonus · ☐ À faire · ☑ Fait

---

### A. Initialisation & environnement

* [ ]  🔴 Créer le dépôt GitHub / GitLab (nom du repo clair)
* [ ] 🔴 Ajouter les 3 membres comme collaborateurs
* [ ] 🔴 Créer le `.gitignore` (`.env`, `vendor/`, `writable/`, `*.log`)
* [ ] 🔴 Copier `env` → `.env` et configurer `DB_*`, `CI_ENVIRONMENT = development`
* [ ] 🔴 Installer CodeIgniter 4 via Composer (`composer create-project`)
* [ ] 🔴 Vérifier que `php spark serve` fonctionne
* [ ] 🟠 Créer la branche `dev` pour le développement, `main` = branche de livraison
* [ ] 🟠 Créer le Google Sheet de suivi des tâches avec colonnes : Tâche / Responsable / Statut / Date
* [ ] 🟠 Rédiger le `README.md` (installation, membres, description)

---

### B. Base de données

* [ ] 🔴 Créer la base MySQL (`regime_s4` ou autre nom)
* [ ] 🔴 Écrire la migration `users`
* [ ] 🔴 Écrire la migration `user_sante`
* [ ] 🔴 Écrire la migration `regimes`
* [ ] 🔴 Écrire la migration `regime_durees` (prix selon durée)
* [ ] 🔴 Écrire la migration `activites`
* [ ] 🔴 Écrire la migration `codes`
* [ ] 🔴 Écrire la migration `user_regimes` (pivot achats)
* [ ] 🟠 Écrire la migration `parametres` (clé/valeur)
* [ ] 🔴 Lancer `php spark migrate` sans erreur
* [ ] 🔴 Seed : 5 utilisateurs (genres mixtes, mots de passe hashés)
* [ ] 🔴 Seed : 5 régimes (avec % viande / poisson / volaille remplis)
* [ ] 🔴 Seed : prix pour chaque régime (au moins 3 durées différentes par régime)
* [ ] 🔴 Seed : 5 activités sportives (avec calories/h et durée recommandée)
* [ ] 🔴 Seed : 15 codes portefeuille (montants variés, tous `is_used = 0`)
* [ ] 🟠 Seed : paramètres (prix Gold, IMC min/max idéal)
* [ ] 🔴 Exporter `script.sql` final et le versionner

---

### C. Authentification

* [ ] 🔴 `AuthFilter.php` — redirige vers `/connexion` si pas de session `user_id`
* [ ] 🔴 `AdminFilter.php` — redirige vers `/admin` si pas de session `admin_id`
* [ ] 🔴 Enregistrer les filtres dans `app/Config/Filters.php`
* [ ] 🔴 Page login utilisateur (formulaire email + mot de passe)
* [ ] 🔴 Vérification `password_verify()` au login
* [ ] 🔴 Stockage session `user_id`, `nom`, `genre`, `is_gold`, `solde`
* [ ] 🔴 Déconnexion (`session()->destroy()`)
* [ ] 🔴 Page login admin séparée (`/admin/login`)
* [ ] 🟠 Message flash d'erreur si mauvais identifiants
* [ ] 🟠 Redirection vers page d'origine après login (si accès refusé)

---

### D. Inscription en 2 étapes

* [ ] 🔴 Étape 1 — Champs : nom, prénom, email, genre, mot de passe, confirmation
* [ ] 🔴 Étape 1 — Validation CI4 (email unique, longueur, correspondance passwords)
* [ ] 🔴 Étape 1 — Stockage des données en session (`register_step1`)
* [ ] 🔴 Étape 2 — Champs : taille (cm), poids (kg), objectif (3 choix radio)
* [ ] 🔴 Étape 2 — Validation CI4 (numérique, plages cohérentes)
* [ ] 🔴 Étape 2 — Insertion dans `users` + `user_sante` en transaction
* [ ] 🔴 Nettoyage session `register_step1` après succès
* [ ] 🟠 Barre de progression visuelle entre les 2 étapes (Step 1/2)
* [ ] 🟠 Redirection vers `/suggestions` après inscription réussie

---

### E. Profil utilisateur

* [ ] 🔴 Page profil affichant toutes les infos (nom, email, genre, taille, poids)
* [ ] 🔴 Affichage de l'IMC calculé et de sa catégorie (badge coloré)
* [ ] 🔴 Affichage du poids idéal estimé
* [ ] 🔴 Formulaire de modification du profil (taille, poids, objectif)
* [ ] 🔴 Mise à jour en base après validation
* [ ] 🟠 Affichage du solde portefeuille et du statut Gold
* [ ] 🟠 Historique des régimes souscrits

---

### F. Calcul IMC live (AJAX)

* [ ] 🔴 Route POST `/ajax/imc` sans filtre auth (accessible depuis l'inscription)
* [ ] 🔴 Controller `calculerImc()` retourne JSON : imc, catégorie, couleur, poids idéal
* [ ] 🔴 `imc.js` — écoute les inputs taille/poids, appel fetch, mise à jour DOM
* [ ] 🟠 Animation / transition sur le badge IMC lors du recalcul
* [ ] 🟠 Affichage de la fourchette IMC idéale (18.5 – 24.9)

---

### G. Objectif & Suggestions de régimes

* [ ] 🔴 Page choix d'objectif (3 cartes cliquables : augmenter / réduire / idéal)
* [ ] 🔴 Sauvegarde de l'objectif en base (`user_sante.objectif`)
* [ ] 🔴 Page suggestions filtre les régimes selon l'objectif et l'IMC actuel
* [ ] 🔴 Affichage des régimes : nom, description, % composition (viande/poisson/volaille)
* [ ] 🔴 Affichage des durées disponibles avec le prix correspondant
* [ ] 🔴 Affichage de la remise Gold (15%) si `is_gold = 1` (prix barré + prix réduit)
* [ ] 🔴 Affichage des activités sportives suggérées
* [ ] 🔴 Bouton "Souscrire" pour chaque régime + durée
* [ ] 🔴 Vérification du solde suffisant avant souscription
* [ ] 🔴 Déduction du prix du solde + insertion dans `user_regimes`
* [ ] 🟠 Indication de la variation de poids attendue par durée

---

### H. Export PDF

* [ ] 🔴 Installer dompdf (`composer require dompdf/dompdf`)
* [ ] 🔴 Vue `pdf_template.php` avec récapitulatif du régime (nom, durée, activité, composition, prix)
* [ ] 🔴 Affichage de l'IMC de l'utilisateur et de l'objectif
* [ ] 🔴 Route `/export-pdf/{id}` protégée par filtre auth
* [ ] 🔴 Vérifier que l'utilisateur ne peut exporter que ses propres régimes
* [ ] 🟠 Logo et mise en page propre dans le PDF
* [ ] 🟠 Date de génération du PDF

---

### I. Portefeuille & codes

* [ ] 🔴 Page portefeuille — affichage du solde actuel
* [ ] 🔴 Formulaire saisie de code (champ texte + bouton)
* [ ] 🔴 Route POST `/ajax/code` — vérification du code en base
* [ ] 🔴 Si valide et non utilisé : créditer le solde, marquer `is_used = 1`, `used_by`, `used_at`
* [ ] 🔴 Retour JSON : succès/erreur, montant ajouté, nouveau solde
* [ ] 🔴 `porte_monnaie.js` — affichage dynamique du résultat sans rechargement
* [ ] 🟠 Message d'erreur si code déjà utilisé ou inexistant
* [ ] 🟠 Historique des codes utilisés par l'utilisateur

---

### J. Option Gold

* [ ] 🔴 Définir le prix Gold dans les paramètres (ex: 29.99 €)
* [ ] 🔴 Page ou section "Passer Gold" avec description des avantages
* [ ] 🔴 Paiement depuis le solde portefeuille (vérifier solde suffisant)
* [ ] 🔴 Mise à jour `users.is_gold = 1` après paiement
* [ ] 🔴 Application automatique de la remise 15% sur toutes les suggestions
* [ ] 🟠 Badge "Gold" visible sur le profil et la navbar
* [ ] 🟠 Affichage du prix avant/après remise (prix barré)

---

### K. Back Office — Dashboard admin

* [ ] 🔴 Page d'authentification admin séparée (`/admin/login`)
* [ ] 🔴 Tableau de bord avec au moins 3 statistiques chiffrées (nb users, nb souscriptions, revenus)
* [ ] 🔴 Graphe 1 : répartition des objectifs utilisateurs (doughnut Chart.js)
* [ ] 🔴 Graphe 2 : régimes les plus souscrits (bar chart)
* [ ] 🟠 Graphe 3 : inscriptions par mois (line chart)
* [ ] 🟠 Tableau croisé : objectif × régime choisi
* [ ] 🟠 Indicateurs Gold : nb utilisateurs Gold, revenus Gold

### K bis. Back Office — Coach

* [ ] 🟠 Définir clairement le périmètre fonctionnel du rôle coach dans les specs
* [ ] 🟠 Ajouter les routes coach dans `app/Config/Routes.php`
* [ ] 🟠 Finaliser le dashboard coach et ses accès
* [ ] 🟠 Vérifier la cohérence entre `users.role`, `CoachFilter` et `Config/AuthGroups`

---

### L. Back Office — CRUD Régimes

* [ ] 🔴 Liste de tous les régimes (tableau avec pagination)
* [ ] 🔴 Formulaire création : nom, description, % viande, % poisson, % volaille
* [ ] 🔴 Validation : somme des % = 100 (contrôle PHP + JS)
* [ ] 🔴 Champs delta poids min/max (variation attendue en kg)
* [ ] 🔴 Section "Durées & Prix" dans le formulaire (ajouter N lignes dynamiquement)
* [ ] 🔴 Modification d'un régime existant (pré-remplissage du formulaire)
* [ ] 🔴 Suppression avec confirmation (vérifier qu'aucun user n'est dessus)
* [ ] 🟠 Aperçu de la composition en graphe (pie chart inline)

---

### M. Back Office — CRUD Activités

* [ ] 🔴 Liste des activités sportives
* [ ] 🔴 Formulaire création/modification : nom, description, calories/h, durée recommandée (min/jour)
* [ ] 🔴 Suppression avec confirmation
* [ ] 🟠 Association activité ↔ objectif (quelle activité pour quel objectif)

---

### N. Back Office — Codes portefeuille

* [ ] 🔴 Liste de tous les codes (code, montant, statut utilisé/libre, utilisé par qui)
* [ ] 🔴 Formulaire génération de code (montant + code unique auto ou manuel)
* [ ] 🔴 Filtres : afficher uniquement les codes libres / utilisés
* [ ] 🟠 Export CSV des codes générés

---

### O. Back Office — Paramètres

* [ ] 🟠 Page liste clé/valeur modifiable : prix Gold, IMC min/max idéal, % remise Gold
* [ ] 🟠 Formulaire de modification (sans supprimer, juste `UPDATE`)
* [ ] 🟠 Les valeurs sont lues dynamiquement dans l'application (pas hardcodées)

---

### P. Interface & UX

* [ ] 🔴 Layout front distinct du layout admin
* [ ] 🔴 Navbar front : logo, profil, portefeuille (solde), déconnexion
* [ ] 🔴 Navbar admin : logo, liens modules, déconnexion
* [ ] 🔴 Messages flash (succès / erreur) sur toutes les actions
* [ ] 🔴 Pages d'erreur 403 / 404 personnalisées
* [ ] 🟠 Responsive mobile (Bootstrap grid)
* [ ] 🟠 Confirmation JavaScript avant toute suppression (`confirm()`)
* [ ] 🟠 Indicateur de chargement sur les requêtes AJAX
* [ ] 🟡 Transitions CSS entre les étapes d'inscription
* [ ] 🟡 Favicon et titre de page dynamique (`<title>`)

---

### Q. Sécurité minimale

* [ ] 🔴 Tous les mots de passe hashés avec `password_hash()` / `password_verify()`
* [ ] 🔴 Token CSRF activé dans CI4 (`Config/Security.php`)
* [ ] 🔴 Filtre auth sur toutes les routes `/profil`, `/suggestions`, `/export-pdf`, etc.
* [ ] 🔴 Filtre admin sur toutes les routes `/admin/*`
* [ ] 🔴 Vérification côté serveur que l'utilisateur ne modifie que ses propres données
* [ ] 🟠 Validation de toutes les entrées avec les règles CI4 (jamais faire confiance au front)
* [ ] 🟠 Échapper toutes les sorties dans les vues (`esc()` de CI4)

---

### R. Git & collaboration

* [ ] 🔴 Premier commit : structure CI4 de base + `.gitignore`
* [ ] 🔴 Commits réguliers tout au long (pas seulement à la fin — critère noté)
* [ ] 🔴 Chaque membre fait ses propres commits (traçabilité individuelle)
* [ ] 🔴 Merge Request / Pull Request de `dev` → `main` avant livraison
* [ ] 🔴 Branche `main` propre et fonctionnelle au moment de la livraison
* [ ] 🟠 Messages de commit clairs (ex: `feat: ajout calcul IMC AJAX`)
* [ ] 🟠 Ne jamais push `.env` ni `vendor/`

---

### S. Livraison finale

* [ ] 🔴 `script.sql` exporté, testé sur une base vierge, versionné dans le repo
* [ ] 🔴 Données minimales présentes : 5 users · 5 régimes · 5 activités · 15 codes
* [ ] 🔴 Lien GitHub / GitLab fonctionnel et public (ou accessible au prof)
* [ ] 🔴 Formulaire Google Forms rempli avec le lien du repo
* [ ] 🔴 Liste des membres du groupe fournie
* [ ] 🔴 Google Sheet suivi des tâches à jour et partagé
* [ ] 🔴 `README.md` avec instructions d'installation complètes
* [ ] 🟠 Tester l'installation depuis zéro sur une machine vierge avant de rendre
