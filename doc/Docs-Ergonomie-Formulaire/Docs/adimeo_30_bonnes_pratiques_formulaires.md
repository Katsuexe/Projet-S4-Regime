# 30 bonnes pratiques pour réussir l'ergonomie de vos formulaires Web

> **Source :** Adimeo — 20 mai 2020 — par Marine Soroko, Directrice associée

Les formulaires Web sont l'outil clé pour passer d'une relation de masse à une transaction individuelle et personnalisée. Cette checklist couvre les bonnes pratiques pour garantir une saisie simple et fluide, quel que soit le support.

---

## Sommaire

1. [Structurer le formulaire](#1-structurer-le-formulaire)
2. [Utiliser des types de champs bien pensés](#2-utiliser-des-types-de-champs-bien-pensés)
3. [Gérer les erreurs et les validations efficacement](#3-gérer-les-erreurs-et-les-validations-efficacement)
4. [Optimiser pour les mobiles](#4-optimiser-pour-les-mobiles)
5. [Travailler l'UX Writing](#5-travailler-lux-writing)

---

## 1. Structurer le formulaire

> **Principe :** La loi de proximité (loi de Gestalt) indique que les éléments proches les uns des autres sont perçus comme une unité. En tirer parti pour organiser visuellement le formulaire.

### #1 — Positionner le formulaire sur une seule colonne

- Pas de colonnage qui oblige l'utilisateur à zigzaguer entre les champs.
- Positionner les **libellés au-dessus du champ** ou sur la même ligne, alignés à droite (pour que le libellé "colle" au champ).
- **Éviter les libellés à l'intérieur des champs** (placeholder) : l'utilisateur perd l'information dès qu'il commence à saisir.

### #2 — Regrouper les champs en zones visuelles

Évite une liste indigeste de champs sur lesquels l'œil ne sait pas où se poser.

### #3 — Créer un formulaire en plusieurs étapes (Wizard)

- Positionner un **chemin de fer explicite** en tête du formulaire (nombre d'étapes, navigation possible entre elles).
- **Sauvegarder chaque saisie en cache** : en cas de perte de connexion ou de sortie accidentelle, l'utilisateur ne repart pas de zéro.
- Minimiser les **temps de transition** entre étapes (avec des micro-interactions pour signaler le passage).

### #4 — Hiérarchiser visuellement les boutons d'action

- Le bouton primaire doit être **coloré et contrasté** par rapport à son environnement.
- Les boutons secondaires (retour en arrière) doivent être moins présents visuellement.

### #5 — Assurer la navigation au clavier (touche TAB)

La touche TAB doit permettre de passer d'un champ à l'autre. Son absence agace les utilisateurs avertis.

### #6 — Ne pas placer "Annuler" à côté du bouton principal

- L'utilisateur peut hésiter entre les deux actions.
- De manière générale, **ne pas proposer d'effacer/annuler** : proposer simplement un retour en arrière.

### #7 — Partir du général pour aller au particulier

Demander les champs principaux en premier, puis les questions plus particulières ou complexes. Il est plus facile de demander une action complexe une fois que les actions perçues comme faciles ont été réalisées.

---

## 2. Utiliser des types de champs bien pensés

### #1 — Choisir le bon type de contrôle

| Type de contrôle | Quand l'utiliser |
|---|---|
| **Bouton radio** | Choix unique parmi plusieurs options |
| **Case à cocher** | Choix multiples possibles |
| **Liste déroulante** | À utiliser avec modération (plusieurs clics nécessaires) |
| **Toggle** | Choix binaire activation/désactivation |

- **Préférer boutons radio / cases à cocher** aux listes déroulantes quand le volume d'alternatives le permet (jusqu'à 5-6 options).
- **Illustrer les alternatives par des images cliquables** : plus engageant qu'un texte seul.
- **Libellés explicites :** au lieu de "Acceptez-vous les CGU ?" + Oui/Non → écrire "J'accepte les conditions générales" / "Je n'accepte pas les conditions générales".

### #2 — Aligner verticalement les options et choix

L'alignement horizontal oblige l'œil à lire une longue ligne qui ne matérialise pas bien les différences entre options. L'alignement **vertical** favorise la compréhension.

### #3 — Utiliser des images pour remplacer les alternatives

Le choix d'images cliquables est plus engageant que des cases à cocher, à condition que l'image soit représentative et accompagnée d'un libellé explicite.

### #4 — Dimensionner la taille des champs selon la réponse attendue

Un champ de code postal doit être court → information implicite que la réponse est brève. Un champ de commentaire long doit être grand.

### #5 — Indiquer les champs obligatoires

- Le symbole `*` est bien intégré, mais doit être positionné **au niveau du libellé**.
- La **légende** du symbole doit être en **début de formulaire**, pas à la fin.
- Éviter la couleur seule pour distinguer les champs obligatoires (problème daltonisme).
- Si la majorité des champs sont obligatoires, **indiquer les champs facultatifs**.

### #6 — Utiliser des fonctions CAPTCHA simples

- Le **reCAPTCHA de Google** est la solution la plus ergonomique.
- De nombreuses études démontrent l'impact très négatif des CAPTCHA sur les taux de conversion → **l'éviter si possible**.

### #7 — Proposer l'auto-complétion pour les listes longues

L'utilisateur accède directement au libellé en saisissant les premières lettres. Particulièrement efficace pour le choix d'un pays ou d'une langue (surtout si l'ordre alphabétique n'est pas respecté).

### #8 — Supprimer les champs inutiles

> Chaque champ supplémentaire diminue le taux de conversion. Les formulaires qui convertissent le mieux ont le moins de champs.

---

## 3. Gérer les erreurs et les validations efficacement

### #1 — Indiquer les erreurs au niveau du champ concerné, de manière explicite

- ❌ "Votre formulaire est incorrect."
- ✅ "Votre adresse e-mail est incorrecte."

Idéalement, **validation en temps réel** : à chaque passage au champ suivant, le précédent affiche une coche de validation ou un message d'erreur.

### #2 — Mettre en valeur le champ en cours de saisie

Changer la couleur de bordure ou mettre un fond de couleur sur la ligne active. Utile particulièrement pour les utilisateurs multitâches.

### #3 — Utiliser des aides et légendes visibles

- Pour un upload : mentionner explicitement les **formats autorisés et le poids maximum**.
- Pour une demande complexe : donner des **exemples**.
- L'aide doit être à **proximité du champ**, sans nécessiter d'ouvrir une nouvelle page (l'utilisateur peut craindre de perdre sa saisie).

### #4 — Ne pas créer des conditions de validation trop rigides

Pour un numéro de téléphone, ne pas forcer le format `+33612...` : utiliser des règles de programmation qui acceptent les différents formats courants.

### #5 — Arrêter de demander la saisie deux fois

Demander l'email ou le mot de passe deux fois n'est pas une bonne pratique. Pour le mot de passe, **proposer une fonction de visualisation en clair** (icône œil).

### #6 — Autoriser le pré-remplissage (AutoFill)

Selon Google, la fonction AutoFill aide les utilisateurs à remplir les formulaires **30 % plus vite**.

---

## 4. Optimiser pour les mobiles

> Sur mobile, l'utilisateur est comme un nageur en apnée : ses doigts sont gourds, il est pressé, il jongle entre plusieurs applications. Un formulaire parfaitement adapté au mobile est toujours apprécié.

### #1 — Concevoir en Mobile First

L'approche Mobile First garantit l'efficacité en situation de mobilité. Il est toujours plus facile d'adapter au desktop ensuite que l'inverse.

### #2 — Éviter les listes déroulantes

Encore plus problématiques sur mobile. Les listes déroulantes sur mobile sont difficiles à utiliser.

### #3 — Proposer les claviers adaptés aux champs

Un clavier numérique pour saisir un montant est très apprécié. Utiliser les attributs HTML appropriés (`inputmode`, `type`).

### #4 — Concevoir des zones tactiles larges

- Cibles d'une largeur **≥ 9 mm** minimum.
- Espaces **suffisants entre les boutons** pour éviter les mauvais clics.

---

## 5. Travailler l'UX Writing

### #1 — Soigner les libellés des boutons de soumission

- ❌ "Envoyer", "OK" → trop vague
- ✅ "Je m'inscris", "Valider ma commande", "Télécharger mon guide"

Utiliser des **verbes d'action** reflétant la finalité réelle du formulaire.

### #2 — Expliquer l'enjeu et les bénéfices dès le début

Les utilisateurs ont des réticences face à un formulaire : serai-je spammé ? Combien de temps ça prend ? Faudra-t-il ma carte bancaire ?

→ Désamorcer ces questions en indiquant **la contrepartie et les bénéfices** dès le début ("Contenu unique, gratuit, livré en 2 minutes…").

### #3 — Expliquer pourquoi des informations sensibles sont demandées

Désamorcer les réticences en expliquant **à quoi va servir l'information** et comment elle sera utilisée. Préciser les engagements RGPD.

### #4 — Ne pas utiliser les majuscules pour les labels

Les majuscules sont **agressives** et se lisent mal.

---

## Conclusion

L'optimisation de formulaires web s'articule autour de trois sujets : **lisibilité**, **organisation visuelle** et **gestion des erreurs**. De nombreux principes sont simples à mettre en œuvre. D'autres nécessitent plus de travail mais ont un impact considérable sur la perception des utilisateurs.

> **Le maître mot reste l'expérimentation.** Testez vos formulaires avec vos utilisateurs et mettez en place des tests A/B.
