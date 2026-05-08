# UX : 10 règles d'or pour la conception de formulaires

> **Source :** Ludotic — Publié le 25 août 2021 par Virginie Hermand (UX Lead, UX Designer)

Le formulaire est quasiment incontournable sur le web : création de compte, validation de commande, démarche administrative, contact support. Une mauvaise ergonomie entraîne des abandons. Le design d'un formulaire doit guider les utilisateurs et faciliter la complétion pour augmenter le taux de conversion (grand public) ou l'efficience (professionnel).

---

## Sommaire

1. [Identifier le contexte et les enjeux](#1-identifier-le-contexte-et-les-enjeux)
2. [Utiliser l'écosystème numérique des utilisateurs](#2-utiliser-lécosystème-numérique-des-utilisateurs)
3. [Organiser le formulaire](#3-organiser-le-formulaire)
4. [Améliorer la lisibilité](#4-améliorer-la-lisibilité)
5. [Utiliser une seule colonne](#5-utiliser-une-seule-colonne)
6. [Guider vos utilisateurs](#6-guider-vos-utilisateurs)
7. [Faciliter la complétion](#7-faciliter-la-complétion)
8. [Penser mobilité](#8-penser-mobilité)
9. [Optimiser l'affichage](#9-optimiser-laffichage)
10. [Tester et surveiller](#10-tester-et-surveiller)

---

## 1. Identifier le contexte et les enjeux

Avant de designer le formulaire, comprendre le contexte est indispensable.

**Côté utilisateurs :**
- À quel moment du parcours le formulaire apparaît-il ?
- À quelle fréquence et par combien d'utilisateurs sera-t-il utilisé ?
- Dans quel but ? Quelles questions l'utilisateur se posera-t-il à cet instant ?
- De quels éléments a-t-il besoin, quels éléments a-t-il à sa disposition ?

**Côté business :**
- Quel est l'objectif à atteindre (taux de conversion, gestion de demandes, finalisation d'un parcours) ?
- Quels sont les risques si les utilisateurs n'utilisent pas le formulaire ?
- De quelles données a-t-on vraiment besoin ?

> **Règle :** Ne demander que les données utiles et traitables — cela réduit le formulaire aux champs strictement nécessaires.

Tout remplissage de formulaire (surtout la création de compte) est un moment pénible. Il faut les afficher au bon moment du parcours et laisser une certaine liberté à l'utilisateur (possibilité de revenir en arrière, etc.).

---

## 2. Utiliser l'écosystème numérique des utilisateurs

Le grand public utilise des outils (smartphones, navigateurs, compte Google…) qui lui facilitent la vie. Il faut en tenir compte.

- **Auto-remplissage navigateur :** le navigateur peut préremplir ou proposer des suggestions pour certains champs (nom, prénom, adresse…) si le format attendu est reconnu via les standards web.
- **Suggestions basées sur l'historique :** utile si l'utilisateur doit recommencer le formulaire après un échec.
- **Standards web :** coder les champs en respectant les standards web permet de mieux prévenir les erreurs (impossible de saisir du texte dans un champ code postal, par exemple).

---

## 3. Organiser le formulaire

Un formulaire avec de nombreux champs peut effrayer au premier regard. L'organisation le rend immédiatement compréhensible.

- **Regrouper les champs par objectif :** ex. tout ce qui touche à l'identité (nom, prénom, adresse) dans une même section.
- **Ajouter un titre à chaque section :** l'utilisateur ne voit plus 10 champs isolés, mais 3 sections claires.
- **Résultat :** des sections et des titres soigneusement choisis allègent visuellement le formulaire et favorisent le passage à l'acte.

---

## 4. Améliorer la lisibilité

La lisibilité s'adapte au public cible et au contexte d'usage.

**Recommandations universelles :**
- Respecter un **ratio de contraste couleur suffisant** (élément distinctement visible par rapport au fond).
- **Afficher le label au-dessus du champ** (et non à gauche) : plus facile à lire.
- Utiliser les **formats standards** de données connus des utilisateurs (date, heure…).
- **Faciliter la lecture des longues suites de chiffres** : `06.12.23.34.45` est plus lisible que `0612233445`.
- Utiliser un **minimum de mots pour un maximum de sens**.
- Dans le titre d'un champ, utiliser des pronoms uniquement si un doute peut persister (ex. "votre adresse" si la position du champ crée une ambiguïté entre adresse personnelle et professionnelle).

---

## 5. Utiliser une seule colonne

Un formulaire **en une seule colonne** est plus facile à lire, à comprendre, et à adapter au mobile.

- L'utilisateur n'a pas à se demander si le formulaire se lit de haut en bas ou de gauche à droite.
- Le regard se dirige immédiatement vers les éléments importants.
- Moins de risques de rater un champ et d'obtenir une erreur à la validation.

> **Exception :** pour des logiciels ou applications métier, un formulaire multi-colonnes est acceptable, à condition que les champs soient organisés en sections avec des titres adaptés.

---

## 6. Guider vos utilisateurs

Le guidage passe à la fois par le **texte** (microcopie) et par le **design**.

### Guider grâce au texte (microcopie)

La microcopie désigne tous les petits textes d'interface qui guident l'action de l'utilisateur.

- **Expliquer pourquoi une donnée sensible est demandée** (ex. numéro de téléphone pour être contacté par le service client en cas de problème).
- **Expliquer comment retrouver une information essentielle** (ex. numéro de dossier) pour diminuer les risques d'abandon.
- **Choisir des titres de champs clairs et sans jargon** (ni technique, ni métier).
- **Supprimer toute ambiguïté** (ex. préciser "adresse personnelle" plutôt que simplement "adresse").
- **Utiliser des labels de texte par défaut (placeholder)** pour indiquer le format attendu — ne pas y mettre des informations essentielles (ils disparaissent à la saisie).
- **Indiquer clairement l'action engendrée par le bouton** : préférer "Envoyer ma demande" ou "Créer un compte" plutôt qu'un générique "Valider".

### Guider grâce au design

- **Indiquer les champs non-obligatoires uniquement** (l'astérisque pour les champs obligatoires n'est pas toujours compris).
- **Adapter la taille des champs au format attendu** : champ court pour un code postal, champ large/haut pour un texte libre.
- **Distinguer visuellement les boutons primaires et secondaires** : validation à droite (plus présente), annulation à gauche (moins présente).
- **Afficher un feedback de chargement** lors de l'envoi (icône tournante) pour éviter que l'utilisateur ne reclique ou quitte la page.

---

## 7. Faciliter la complétion

### Durant la complétion des champs

- **Être flexible :** plusieurs façons d'entrer une donnée doivent être acceptées (ex. date picker + saisie libre).
- **Regrouper plusieurs champs d'une même unité sémantique :** ex. la date en un seul champ, ou passage automatique au champ suivant à la fin de la saisie.
- **Ne pas demander deux fois la même donnée :** inutile pour l'email (les utilisateurs le connaissent par cœur). Exception possible : le mot de passe.
- **Permettre de voir le mot de passe saisi** grâce à une icône œil, pour éviter les fautes de frappe.

### À la validation du formulaire

- **Attention au CAPTCHA :** privilégier les solutions les plus simples (ex. reCAPTCHA Google). Un CAPTCHA trop difficile bloque aussi les humains.
- **Messages d'erreur précis :** indiquer clairement la nature du problème, avec des solutions si possible. Le champ concerné change de couleur de bordure, et le message apparaît sous ce champ.
- **Ne pas attendre la validation finale** pour signaler les erreurs : mettre en place une **vérification automatique à la sortie du champ** (pas à l'entrée).
- **Griser le bouton de validation** tant que tous les champs obligatoires ne sont pas correctement remplis.

---

## 8. Penser mobilité

> **Principe :** Concevoir d'abord en version mobile, puis adapter au desktop.

**Conseils spécifiques au mobile (critiques) :**

- **Ne pas distraire :** éviter les pop-ups, éléments sticky, publicités ou animations. Isoler le formulaire avec un fond de couleur unie.
- **Champs codés avec les standards web :** le smartphone affiche automatiquement le bon clavier (numérique pour un numéro de téléphone, etc.).
- **Utiliser l'autofocus :** le champ sélectionné se positionne automatiquement au-dessus du clavier.
- **Mettre en évidence le champ actif** (changement de couleur de bordure) : sur mobile, la visibilité de la page est très réduite avec le clavier affiché.

---

## 9. Optimiser l'affichage

### Quand un formulaire est long

**Problèmes d'un long formulaire en une seule page :**
- Plus difficile à compléter sur mobile.
- Peut effrayer et causer des abandons.
- Risque accru d'erreurs à la validation.
- Plus difficile à scanner pour repérer les erreurs.

### Solution : formulaire en plusieurs étapes

Si vous optez pour un formulaire multi-étapes, respecter :

- **Regrouper les champs similaires** (nom + prénom + date de naissance = Identité / adresse + livraison = Livraison…).
- **Suivre un ordre logique** pour les étapes et les champs.
- **Donner un sens de progression** : barre de progression + étapes numérotées.
- **Permettre de revenir en arrière** à tout moment.
- **Donner les informations essentielles au bon moment** (ex. rappeler le panier, le montant total, l'adresse et le choix de livraison juste avant le paiement).

> **Alternative :** afficher tout sur une page mais découper en sections, l'utilisateur devant valider chaque section avant de passer à la suivante.

---

## 10. Tester et surveiller

### L'anecdote Expedia

Expedia a perdu **12 millions de dollars par an** en ajoutant un simple champ "Nom de la société" au-dessus du champ adresse : les utilisateurs indiquaient l'adresse de leur banque (logique dans la continuité du formulaire), ce qui faisait échouer la vérification d'adresse de la carte bancaire.

### Tests utilisateurs

Le test utilisateur est la seule solution pour s'assurer de l'utilisabilité d'un formulaire et comprendre les freins à la complétion. Il permet d'**observer directement ce qui fonctionne** et d'**échanger avec les participants** pour comprendre pourquoi.

**Enjeux selon le public :**
- **Grand public** (inscription, commande, devis) : enjeux de revenus et de conversion.
- **Professionnel** (rapport, saisie métier) : enjeux d'efficience et de gain de temps.

### Analytics

Les analytics permettent de **surveiller l'usage réel** : tout changement peut entraîner une hausse ou une baisse du taux de complétion. Une baisse inexpliquée est le signal pour lancer un test utilisateur.

---

## Conclusion

Avec ces 10 règles, vous éviterez les principaux écueils de la conception de formulaires. L'expérience naît de l'interaction avec un objet et du contexte d'usage — testez toujours vos formulaires et surveillez vos analytics en production.
