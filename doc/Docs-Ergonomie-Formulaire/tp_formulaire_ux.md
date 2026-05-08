# 🧪 TP : Amélioration UX dʼun formulaire web

## 🎯 Objectifs pédagogiques

Identifier les problèmes UX dʼun formulaire
Appliquer les bonnes pratiques (UX, structure, lisibilité)
Implémenter un formulaire HTML propre
Améliorer lʼexpérience utilisateur

## 📦 Contexte

Une entreprise souhaite améliorer son formulaire dʼinscription.
Le formulaire actuel génère beaucoup dʼabandons.

👉 Votre mission : analyser et améliorer ce formulaire

# 🔴 PARTIE 1 – Analyse

## 📌 Formulaire initial

```html
<form>
  Nom : <input type="text" /><br /><br />
  Prénom : <input type="text" /><br /><br />
  Email : <input type="text" /><br /><br />
  Confirmer Email : <input type="text" /><br /><br />
  Mot de passe : <input type="password" /><br /><br />
  Confirmer mot de passe : <input type="password" /><br /><br />
  Date de naissance :
  <input type="text" placeholder="JJ" />
  <input type="text" placeholder="MM" />
  <input type="text" placeholder="AAAA" /><br /><br />

  Pays :
  <select>
    <option>Choisir</option>
    <option>France</option>
    <option>Madagascar</option></select>
  <br /><br />

  Téléphone : <input type="text" /><br /><br />

  <button>Envoyer</button>
  <button>Annuler</button>
</form>
```

## 📝 Travail demandé

Lister au moins 10 problèmes UX

# 🟡 PARTIE 2 – Conception UX

## 🎯 Objectif

Proposer une version améliorée du formulaire

## 📌 Contraintes

Une seule colonne
Sections logiques
Supprimer champs inutiles
Boutons explicites
Améliorer labels

# 🟢 PARTIE 3 – Implémentation HTML

## 🎯 Objectif

Coder le formulaire amélioré

## 📌 Contraintes

Utiliser
Utiliser types adaptés (email, password...)
Utiliser

```
et
```

## ✅ Exemple simplifié

```html
<form>
  <fieldset>
    <legend>Informations personnelles</legend>

    <label for="nom">Nom</label>
    <input type="text" id="nom" name="nom" />

    <label for="prenom">Prénom</label>
    <input type="text" id="prenom" name="prenom" />

    <label for="email">Email</label>

    <input type="email" id="email" name="email" />
  </fieldset>

  <fieldset>
    <legend>Sécurité</legend>

    <label for="password">Mot de passe</label>
    <input type="password" id="password" name="password" />
  </fieldset>

  <button type="submit">Créer mon compte</button>
</form>
```

# 🔵 PARTIE 4 – BONUS

Ajouter :

```
Messages dʼerreur
CSS (champ actif)
Affichage mot de passe
```

|

# 🚀 Extension

```
Ajouter validation JS
Version mobile CSS
Tests utilisateurs
```
