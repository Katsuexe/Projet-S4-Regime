# Cheatsheet : Balises HTML pour les formulaires

> **Source :** Html-form.md — 2025-03-17

---

## 1. `<form>` — Définir le formulaire

Définit un formulaire HTML permettant de collecter des entrées utilisateur.

```html
<form action="/submit" method="post">
  <!-- Champs du formulaire -->
</form>
```

| Attribut | Description |
|---|---|
| `action` | URL où les données seront envoyées |
| `method` | Méthode HTTP : `GET` ou `POST` |

---

## 2. `<input>` — Champ de saisie

Permet de créer un champ de saisie.

```html
<input type="text" name="nom" placeholder="Votre nom">
```

| Attribut | Description |
|---|---|
| `type` | Type du champ : `text`, `password`, `email`, `number`, `tel`, `date`, `checkbox`, `radio`, `file`… |
| `name` | Nom du champ envoyé au serveur |
| `placeholder` | Texte indicatif dans le champ |
| `id` | Identifiant unique (lié au `<label>`) |
| `required` | Champ obligatoire |
| `disabled` | Champ désactivé |
| `autofocus` | Focus automatique au chargement |
| `autocomplete` | Active/désactive l'auto-complétion |
| `inputmode` | Type de clavier mobile (`numeric`, `email`, `tel`…) |

---

## 3. `<label>` — Libellé de champ

Associe un libellé à un champ de formulaire.

```html
<label for="email">Email :</label>
<input type="email" id="email" name="email">
```

| Attribut | Description |
|---|---|
| `for` | Identifiant du champ auquel le label est associé |

**Pourquoi utiliser `<label>` avec `for` ?**
- Améliore l'**accessibilité** (lecteurs d'écran).
- **Agrandit la zone cliquable** pour l'utilisateur.
- Meilleure **structure et expérience utilisateur**.

---

## 4. `<textarea>` — Texte long

Permet de saisir un texte long (commentaire, description, message…).

```html
<textarea name="message" rows="4" cols="30" placeholder="Votre message">
</textarea>
```

| Attribut | Description |
|---|---|
| `rows` | Nombre de lignes visibles |
| `cols` | Largeur en nombre de caractères |
| `placeholder` | Texte indicatif |
| `maxlength` | Nombre maximum de caractères |

---

## 5. `<select>` et `<option>` — Menu déroulant

Crée un menu déroulant.

```html
<select name="pays">
  <option value="fr">France</option>
  <option value="us">États-Unis</option>
</select>
```

| Attribut | Description |
|---|---|
| `name` | Nom du champ envoyé au serveur |
| `multiple` | Permet la sélection multiple |
| `size` | Nombre d'options visibles sans dérouler |
| `selected` (sur `<option>`) | Option sélectionnée par défaut |

---

## 6. `<optgroup>` — Regrouper des options

Regroupe des options dans une liste déroulante pour améliorer la lisibilité.

```html
<select name="voiture">
  <optgroup label="Françaises">
    <option value="renault">Renault</option>
    <option value="peugeot">Peugeot</option>
  </optgroup>
  <optgroup label="Allemandes">
    <option value="bmw">BMW</option>
    <option value="audi">Audi</option>
  </optgroup>
</select>
```

| Attribut | Description |
|---|---|
| `label` | Nom du groupe affiché dans la liste |

---

## 7. `<button>` — Bouton cliquable

```html
<button type="submit">Envoyer</button>
```

| Valeur de `type` | Comportement |
|---|---|
| `submit` | Envoie le formulaire |
| `reset` | Réinitialise tous les champs |
| `button` | Bouton générique (action via JS) |

---

## 8. `<fieldset>` et `<legend>` — Grouper des champs

Groupe plusieurs champs liés sémantiquement.

```html
<fieldset>
  <legend>Informations personnelles</legend>
  <label for="prenom">Prénom :</label>
  <input type="text" id="prenom" name="prenom">
</fieldset>
```

- `<legend>` : titre du groupe de champs (affiché visuellement et lu par les lecteurs d'écran).

---

## 9. `<datalist>` — Suggestions de saisie

Suggère des options dans un champ de texte (autocomplétion non contraignante).

```html
<input list="villes" name="ville" placeholder="Votre ville">
<datalist id="villes">
  <option value="Paris">
  <option value="Lyon">
  <option value="Marseille">
</datalist>
```

> L'utilisateur peut choisir une suggestion ou saisir librement une valeur non listée.

---

## 10. `<output>` — Afficher un résultat calculé

Affiche un résultat basé sur un calcul réalisé dans le formulaire.

```html
<form oninput="result.value = parseInt(a.value) + parseInt(b.value)">
  <input type="number" id="a" name="a"> +
  <input type="number" id="b" name="b"> =
  <output name="result" for="a b"></output>
</form>
```

---

## 11. `<progress>` et `<meter>` — Indicateurs visuels

Indiquent une progression ou une mesure.

```html
<!-- Barre de progression -->
<progress value="50" max="100"></progress>

<!-- Mesure dans une plage -->
<meter value="2" min="0" max="10"></meter>
```

| Balise | Usage typique |
|---|---|
| `<progress>` | Progression d'un téléchargement, d'un formulaire multi-étapes |
| `<meter>` | Mesure scalaire (niveau de batterie, score, stock…) |

---

## Récapitulatif des balises

| Balise | Rôle |
|---|---|
| `<form>` | Conteneur du formulaire |
| `<input>` | Champ de saisie (multiples types) |
| `<label>` | Libellé associé à un champ |
| `<textarea>` | Zone de texte multi-lignes |
| `<select>` | Liste déroulante |
| `<option>` | Option dans une liste déroulante |
| `<optgroup>` | Groupe d'options dans une liste |
| `<button>` | Bouton (submit / reset / button) |
| `<fieldset>` | Groupe de champs liés |
| `<legend>` | Titre d'un fieldset |
| `<datalist>` | Liste de suggestions pour un input |
| `<output>` | Résultat d'un calcul |
| `<progress>` | Barre de progression |
| `<meter>` | Indicateur de mesure scalaire |
