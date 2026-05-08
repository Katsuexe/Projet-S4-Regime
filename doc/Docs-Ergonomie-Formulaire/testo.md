## problèmes UX

| #  | Problème                                                 | Pourquoi c'est un problème                                                  |
| -- | --------------------------------------------------------- | ---------------------------------------------------------------------------- |
| 1  | `<form>` sans `action` ni `method`                  | Les données ne peuvent pas être envoyées                                  |
| 2  | Pas de `<label>` liés aux champs (juste du texte brut) | Inaccessible, zone cliquable réduite, lecteurs d'écran ne font pas le lien |
| 3  | `type="text"` pour l'email                              | Pas de validation native, pas le bon clavier mobile                          |
| 4  | `type="text"` pour le téléphone                       | Idem — devrait être `type="tel"`                                         |
| 5  | Email demandé deux fois                                  | Inutile et frustrant — les utilisateurs connaissent leur email              |
| 6  | Mot de passe demandé deux fois                           | Même problème — préférer une icône d'affichage                         |
| 7  | Date de naissance en 3 champs séparés                   | L'utilisateur doit cliquer 3 fois pour une seule donnée                     |
| 8  | Aucun champ n'a de `name`, `id` ni `required`       | Inutilisable côté serveur, pas de validation possible                      |
| 9  | Bouton "Annuler" collé au bouton "Envoyer"               | Risque élevé de clic accidentel — perte de toute la saisie                |
| 10 | Bouton "Envoyer" trop générique                         | Ne reflète pas l'action réelle (s'inscrire)                                |
| 11 | Pas de sections /`<fieldset>`                           | Champs mélangés sans logique visuelle — charge cognitive élevée         |
| 12 | Mise en page avec `<br><br>`                            | Mauvaise pratique HTML — doit être géré en CSS                           |
| 13 | Pas d'`autocomplete`                                    | Empêche le navigateur de préremplir                                        |
| 14 | Pas de feedback visuel sur le champ actif                 | L'utilisateur ne sait pas où il est, surtout sur mobile                     |
| 15 | Aucune indication de champs obligatoires                  | L'utilisateur découvre les erreurs seulement après validation              |

---

## Partie 2 — Conception UX améliorée

**Champs supprimés :**

- "Confirmer email" → supprimé (inutile)
- "Confirmer mot de passe" → remplacé par icône d'affichage
- "Téléphone" → facultatif (non essentiel à l'inscription)

**Regroupement en sections logiques :**

```
Section 1 — Identité
  └─ Nom / Prénom / Date de naissance

Section 2 — Connexion
  └─ Email / Mot de passe (avec œil)

Section 3 — Localisation (optionnelle)
  └─ Pays

Bouton → "Créer mon compte"
```

---

## Partie 3 — Implémentation HTML

```html
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Formulaire d'inscription</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>

  <form action="/inscription" method="post" novalidate id="form-inscription">
    <h1>Créer un compte</h1>
    <p>Les champs marqués d'un <span aria-hidden="true">*</span> sont obligatoires.</p>

    <!-- SECTION 1 : Identité -->
    <fieldset>
      <legend>Identité</legend>

      <label for="nom">Nom *</label>
      <input
        type="text"
        id="nom"
        name="nom"
        autocomplete="family-name"
        required
        placeholder="Ex. Dupont"
      />
      <span class="erreur" id="erreur-nom" aria-live="polite"></span>

      <label for="prenom">Prénom *</label>
      <input
        type="text"
        id="prenom"
        name="prenom"
        autocomplete="given-name"
        required
        placeholder="Ex. Marie"
      />
      <span class="erreur" id="erreur-prenom" aria-live="polite"></span>

      <label for="ddn">Date de naissance *</label>
      <input
        type="date"
        id="ddn"
        name="ddn"
        autocomplete="bday"
        required
      />
      <span class="erreur" id="erreur-ddn" aria-live="polite"></span>

    </fieldset>

    <!-- SECTION 2 : Connexion -->
    <fieldset>
      <legend>Connexion</legend>

      <label for="email">Adresse email *</label>
      <input
        type="email"
        id="email"
        name="email"
        autocomplete="email"
        required
        placeholder="Ex. marie.dupont@email.com"
        inputmode="email"
      />
      <span class="erreur" id="erreur-email" aria-live="polite"></span>

      <label for="password">Mot de passe *</label>
      <div class="champ-password">
        <input
          type="password"
          id="password"
          name="password"
          autocomplete="new-password"
          required
          placeholder="8 caractères minimum"
          minlength="8"
        />
        <button
          type="button"
          id="toggle-password"
          aria-label="Afficher le mot de passe"
        >👁</button>
      </div>
      <span class="aide">Minimum 8 caractères.</span>
      <span class="erreur" id="erreur-password" aria-live="polite"></span>

    </fieldset>

    <!-- SECTION 3 : Localisation -->
    <fieldset>
      <legend>Localisation <span class="optionnel">(facultatif)</span></legend>

      <label for="pays">Pays</label>
      <select id="pays" name="pays" autocomplete="country">
        <option value="">— Sélectionner —</option>
        <option value="MG">Madagascar</option>
        <option value="FR">France</option>
        <option value="BE">Belgique</option>
        <option value="CH">Suisse</option>
        <option value="CA">Canada</option>
      </select>

      <label for="tel">Téléphone</label>
      <input
        type="tel"
        id="tel"
        name="tel"
        autocomplete="tel"
        placeholder="Ex. +261 34 00 000 00"
        inputmode="tel"
      />

    </fieldset>

    <button type="submit" id="btn-submit">Créer mon compte</button>

  </form>

  <script src="script.js"></script>
</body>
</html>
```

---

## Partie 4 (Bonus) — CSS + JS

### `style.css`

```css
/* ── Reset & base ─────────────────────────────── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
  font-family: system-ui, sans-serif;
  background: #f5f5f5;
  display: flex;
  justify-content: center;
  padding: 2rem 1rem;
  min-height: 100vh;
}

/* ── Formulaire ───────────────────────────────── */
form {
  background: #fff;
  padding: 2rem;
  border-radius: 12px;
  box-shadow: 0 2px 12px rgba(0,0,0,.08);
  width: 100%;
  max-width: 480px;
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

form h1 {
  font-size: 1.4rem;
  color: #1a1a1a;
}

form > p {
  font-size: 0.85rem;
  color: #666;
}

/* ── Fieldset ─────────────────────────────────── */
fieldset {
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  padding: 1.2rem;
  display: flex;
  flex-direction: column;
  gap: 0.6rem;
}

legend {
  font-weight: 600;
  font-size: 0.95rem;
  color: #333;
  padding: 0 0.4rem;
}

.optionnel {
  font-weight: 400;
  color: #888;
  font-size: 0.8rem;
}

/* ── Labels ───────────────────────────────────── */
label {
  font-size: 0.9rem;
  font-weight: 500;
  color: #333;
  margin-top: 0.6rem;
}

/* ── Inputs & select ──────────────────────────── */
input, select {
  width: 100%;
  padding: 0.65rem 0.8rem;
  border: 1.5px solid #ccc;
  border-radius: 6px;
  font-size: 1rem;
  color: #1a1a1a;
  background: #fafafa;
  transition: border-color 0.2s, box-shadow 0.2s;
}

/* Champ actif (BONUS) */
input:focus, select:focus {
  outline: none;
  border-color: #4f7ef8;
  box-shadow: 0 0 0 3px rgba(79,126,248,.2);
  background: #fff;
}

/* Champ invalide après interaction */
input.invalide {
  border-color: #e53e3e;
  background: #fff5f5;
}

input.valide {
  border-color: #38a169;
  background: #f0fff4;
}

/* ── Mot de passe avec icône ──────────────────── */
.champ-password {
  position: relative;
}

.champ-password input {
  padding-right: 3rem;
}

#toggle-password {
  position: absolute;
  right: 0.6rem;
  top: 50%;
  transform: translateY(-50%);
  background: none;
  border: none;
  cursor: pointer;
  font-size: 1.1rem;
  padding: 0.2rem;
  line-height: 1;
}

/* ── Messages d'aide et d'erreur ──────────────── */
.aide {
  font-size: 0.78rem;
  color: #666;
}

.erreur {
  font-size: 0.78rem;
  color: #e53e3e;
  min-height: 1rem;
  display: block;
}

/* ── Bouton submit ────────────────────────────── */
#btn-submit {
  padding: 0.8rem;
  background: #4f7ef8;
  color: #fff;
  border: none;
  border-radius: 8px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.2s, opacity 0.2s;
}

#btn-submit:hover { background: #3a67e0; }
#btn-submit:disabled { background: #b0c4f8; cursor: not-allowed; opacity: 0.7; }

/* ── Mobile ───────────────────────────────────── */
@media (max-width: 480px) {
  form { padding: 1.2rem; }
}
```

### `script.js`

```js
// ── Afficher / masquer le mot de passe ──────────
const passwordInput = document.getElementById('password');
const toggleBtn     = document.getElementById('toggle-password');

toggleBtn.addEventListener('click', () => {
  const visible = passwordInput.type === 'text';
  passwordInput.type = visible ? 'password' : 'text';
  toggleBtn.textContent = visible ? '👁' : '🙈';
  toggleBtn.setAttribute('aria-label',
    visible ? 'Afficher le mot de passe' : 'Masquer le mot de passe'
  );
});

// ── Règles de validation ─────────────────────────
const regles = {
  nom:      { requis: true,  message: "Le nom est requis." },
  prenom:   { requis: true,  message: "Le prénom est requis." },
  ddn:      { requis: true,  message: "La date de naissance est requise." },
  email: {
    requis: true,
    tester: v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v),
    message: "Adresse email invalide."
  },
  password: {
    requis: true,
    tester: v => v.length >= 8,
    message: "Le mot de passe doit contenir au moins 8 caractères."
  }
};

// ── Valider un champ individuel ──────────────────
function validerChamp(champ) {
  const regle  = regles[champ.id];
  if (!regle) return true;

  const valeur = champ.value.trim();
  const erreurEl = document.getElementById('erreur-' + champ.id);
  let message = '';

  if (regle.requis && !valeur) {
    message = regle.message;
  } else if (valeur && regle.tester && !regle.tester(valeur)) {
    message = regle.message;
  }

  // Afficher ou masquer le message
  if (erreurEl) erreurEl.textContent = message;

  // Classes visuelles
  champ.classList.toggle('invalide', !!message);
  champ.classList.toggle('valide', !message && !!valeur);

  return !message;
}

// ── Validation à la sortie du champ (blur) ───────
document.querySelectorAll('input').forEach(input => {
  input.addEventListener('blur', () => validerChamp(input));
});

// ── Validation à la soumission ───────────────────
document.getElementById('form-inscription').addEventListener('submit', e => {
  e.preventDefault();

  let formulaireValide = true;

  document.querySelectorAll('input').forEach(input => {
    if (!validerChamp(input)) formulaireValide = false;
  });

  if (formulaireValide) {
    // Simuler un envoi réussi
    const btn = document.getElementById('btn-submit');
    btn.textContent = '⏳ Envoi en cours…';
    btn.disabled = true;

    setTimeout(() => {
      btn.textContent = '✅ Compte créé !';
    }, 1500);
  }
});
```

---

**Résultat final :** un formulaire en 3 fichiers (`index.html`, `style.css`, `script.js`) avec :

- structure sémantique (`fieldset`, `legend`, `label` liés par `for`/`id`)
- types de champs corrects (`email`, `tel`, `date`, `password`)
- validation en temps réel à la sortie du champ
- messages d'erreur localisés et accessibles (`aria-live`)
- affichage/masquage du mot de passe
- feedback visuel sur le champ actif (CSS `:focus`)
- bouton de soumission avec état de chargement
