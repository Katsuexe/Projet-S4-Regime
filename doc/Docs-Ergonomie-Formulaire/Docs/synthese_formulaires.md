# Conception de formulaires Web — UX & bonnes pratiques

> **Synthèse de cours**

---

## Objectifs

- Comprendre les **enjeux UX** des formulaires
- Identifier les **erreurs fréquentes**
- Appliquer les **bonnes pratiques**
- Concevoir un **formulaire efficace**

---

## Pourquoi les formulaires sont critiques ?

Les formulaires sont un **point clé de conversion** : ils représentent souvent la dernière étape d'un parcours utilisateur, et constituent une **forte source d'abandon**.

> ⚠️ Une mauvaise conception peut entraîner des pertes financières importantes.
> Ex. : Expedia a perdu 12 M$/an à cause d'un seul champ mal placé.

---

## 1. Comprendre le contexte

Avant de concevoir, poser les bonnes questions.

| Côté utilisateur                  | Côté business                                     |
| ----------------------------------- | --------------------------------------------------- |
| Pourquoi remplit-il le formulaire ? | Quel objectif métier ?                             |
| À quel moment du parcours ?        | Quelles données sont vraiment utiles ?             |
| Sur quel appareil ?                 | Quel risque si le formulaire n'est pas complété ? |

> **Règle d'or : demander uniquement l'essentiel.**

### Erreur classique

- Trop de champs
- Informations inutiles demandées
- Mauvais timing dans le parcours

→ Résultat : **abandon** et **frustration**.

---

## 2. Structure d'un bon formulaire

> L'utilisateur doit comprendre le formulaire en **3 secondes**.

- **Une seule colonne**
- **Champs regroupés** par thématique
- **Sections avec titres** clairs
- **Ordre logique** (du général au particulier)

### Exemple de structuration

| ❌ Mauvais                            | ✅ Bon                                                       |
| ------------------------------------- | ------------------------------------------------------------ |
| Liste longue de champs non organisés | Section "Identité" / Section "Adresse" / Section "Paiement" |

→ Réduction de la **charge cognitive**.

### Formulaires longs : la solution multi-étapes (Wizard)

- Barre de **progression** visible
- **Navigation** possible entre les étapes
- Sauvegarde des saisies en cache
- Donne un **sentiment d'avancement**

---

## 3. Lisibilité

| Bonne pratique                     | Exemple                                       |
| ---------------------------------- | --------------------------------------------- |
| Labels**au-dessus** du champ | ✅                                            |
| Bon**contraste** couleur     | Texte lisible sur fond clair/sombre           |
| **Espacement** suffisant     | Pas de champs entassés                       |
| **Formats connus**           | `06.12.23.34.45` plutôt que `0612233445` |

---

## 4. UX Writing

Les textes du formulaire doivent être clairs et orientés action.

| ❌ À éviter          | ✅ À préférer           |
| ---------------------- | -------------------------- |
| "Envoyer"              | "Créer mon compte"        |
| "OK"                   | "Valider ma commande"      |
| "Formulaire incorrect" | "Votre email est invalide" |

> **Règle :** Toujours être explicite. L'utilisateur ne doit jamais hésiter.

---

## 5. Guidage utilisateur

- **Champ actif visible** (bordure colorée, focus visible)
- **Instructions claires** à proximité du champ concerné
- **Aides contextuelles** (tooltip, texte d'aide)
- **Microcopie** pour expliquer pourquoi une donnée sensible est demandée

---

## 6. Types de champs

| Type de contrôle         | Quand l'utiliser                                   |
| ------------------------- | -------------------------------------------------- |
| **Radio**           | Choix unique                                       |
| **Checkbox**        | Choix multiple                                     |
| **Select**          | À éviter si possible (complexe, plusieurs clics) |
| **Image cliquable** | Plus engageant que texte seul                      |

> 💡 Une image cliquable est souvent plus engageante qu'un bouton radio ou une case à cocher.

---

## 7. Faciliter la saisie

- **Autofill navigateur** : laisser le navigateur préremplir.
- **Auto-complétion** : pour les listes longues.
- **Champs adaptés** au format de données attendu (taille, clavier).
- **Ne pas demander deux fois** la même donnée (ex. email).
- **Mot de passe :** proposer l'affichage avec icône 👁 → évite les erreurs de saisie.

### À éviter absolument

- Demander l'email deux fois
- CAPTCHA complexe
- Formats de validation trop stricts (ex. obliger `+33` pour un numéro)

→ **Frustration immédiate** et abandon.

---

## 8. Gestion des erreurs

### Validation en temps réel

- Vérifier **à la sortie du champ** (pas à l'entrée).
- Indiquer l'erreur **immédiatement** et **localement** (sous le champ concerné).
- Réduit la frustration et facilite la correction.

### Feedback utilisateur

- **Loader** de chargement après soumission.
- **Bouton désactivé** (grisé) si les champs obligatoires ne sont pas valides.
- **Confirmation visuelle** après envoi réussi.

---

## 9. Mobile First

> Sur mobile, l'utilisateur est dans un contexte difficile : doigts gourds, écran petit, clavier affiché qui réduit la visibilité.

**Concevoir mobile d'abord, puis adapter au desktop.**

### Bonnes pratiques mobile

| Règle                        | Détail                                                                     |
| ----------------------------- | --------------------------------------------------------------------------- |
| **Clavier adapté**     | `inputmode="numeric"` pour les chiffres, `type="email"` pour les emails |
| **Zones larges**        | Zone tactile ≥ 9 mm, espacement suffisant entre boutons                    |
| **Autofocus**           | Champ actif positionné au-dessus du clavier automatiquement                |
| **Pas de distractions** | Éviter pop-ups, animations, éléments sticky                              |

### À éviter sur mobile

- Listes déroulantes longues
- Petits boutons trop proches
- Pop-ups intrusifs

---

## 10. Tests et mesures

### Tests utilisateurs

| Pourquoi ?                   | Comment ?                        |
| ---------------------------- | -------------------------------- |
| Identifier les blocages      | Observation directe              |
| Comprendre les comportements | Feedback verbal des participants |

### Analytics

Mesurer en production pour améliorer en continu :

| Métrique                      | Ce qu'elle révèle                                   |
| ------------------------------ | ----------------------------------------------------- |
| **Taux de complétion**  | Proportion d'utilisateurs qui terminent le formulaire |
| **Taux d'abandon**       | Où les utilisateurs décrochent                      |
| **Temps de remplissage** | Complexité perçue du formulaire                     |

> **Mesurer pour améliorer.** Une baisse du taux de complétion est le signal pour lancer un test utilisateur.

---

## Exemple de structure HTML de base

```html
<form action="/submit" method="post">
  <label for="email">Email</label>
  <input type="email" id="email" name="email" required autocomplete="email">
  <button type="submit">Créer mon compte</button>
</form>
```

---

## Checklist rapide

- [ ] Seuls les champs **strictement nécessaires** sont présents
- [ ] Formulaire sur **une seule colonne**
- [ ] Champs **regroupés en sections** avec titres
- [ ] Labels **au-dessus** des champs
- [ ] Bouton de soumission avec **verbe d'action explicite**
- [ ] **Champs obligatoires** indiqués (pas uniquement par la couleur)
- [ ] **Validation en temps réel** à la sortie du champ
- [ ] **Messages d'erreur** précis et localisés
- [ ] **AutoFill** autorisé
- [ ] **Mot de passe** avec icône d'affichage
- [ ] **Mobile First** : claviers adaptés, zones tactiles ≥ 9 mm
- [ ] **Feedback** visuel lors de l'envoi (loader, confirmation)
- [ ] Formulaire **testé avec des utilisateurs réels**
- [ ] **Analytics** en place pour surveiller le taux de complétion
