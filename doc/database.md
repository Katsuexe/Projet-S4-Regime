# Schema de Base de Donnees

Le schema principal comprend 8 tables metier :

- `users` : comptes utilisateur, role, genre, statut Gold et solde portefeuille
- `user_sante` : taille, poids et objectif (`augmenter`, `reduire`, `ideal`)
- `regimes` : catalogue des regimes et variation de poids attendue
- `regime_durees` : prix d'un regime selon la duree choisie
- `activites` : activites sportives complementaires
- `codes` : codes de recharge du portefeuille
- `user_regimes` : historique des souscriptions
- `parametres` : configuration dynamique de l'application

Le schema SQL complet livre avec le projet se trouve dans `script.sql` a la racine.

En attendant une documentation table par table plus detaillee, ce fichier sert de resume fonctionnel du modele de donnees effectivement utilise par le depot.
