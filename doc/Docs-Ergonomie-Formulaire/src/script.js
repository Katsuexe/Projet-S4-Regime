
// --- Gestion de l'affichage/masquage du mot de passe ---
// Permet à l'utilisateur d'afficher ou masquer le mot de passe via un bouton "œil".
const passwordInput = document.getElementById("password");
const toggleBtn = document.getElementById("toggle-password");
const passwordConfirmInput = document.getElementById("password-confirm");
const toggleConfirmBtn = document.getElementById("toggle-password-confirm");

if (toggleBtn && passwordInput) {
  toggleBtn.addEventListener("click", () => {
    const visible = passwordInput.type === "text";
    passwordInput.type = visible ? "password" : "text";
    toggleBtn.textContent = visible ? "🙉" : "🙈";
    toggleBtn.setAttribute(
      "aria-label",
      visible ? "Afficher le mot de passe" : "Masquer le mot de passe",
    );
  });
}

if (toggleConfirmBtn && passwordConfirmInput) {
  toggleConfirmBtn.addEventListener("click", () => {
    const visible = passwordConfirmInput.type === "text";
    passwordConfirmInput.type = visible ? "password" : "text";
    toggleConfirmBtn.textContent = visible ? "🙉" : "🙈";
    toggleConfirmBtn.setAttribute(
      "aria-label",
      visible ? "Afficher le mot de passe de confirmation" : "Masquer le mot de passe de confirmation",
    );
  });
}


// --- Import des fonctions utilitaires pour la validation et la gestion des préfixes ---
import {
  validerChamp,
  construirePrefixes,
  extrairePrefixeDuLabel,
  // normaliserTel,
  detecterPaysDepuisTel,
  chercherPaysParPrefixSimple,
  chargerDonneesFormulaire,
  // mettreAJourPrefixeTel
} from './form-utils.js';


// --- Sélection de tous les champs input du formulaire pour la validation ---
const inputs = Array.from(document.querySelectorAll("input"));


// --- Validation individuelle des champs à la sortie du focus (blur) ---
// Ajoute un écouteur sur chaque input pour valider dès que l'utilisateur quitte le champ.
inputs.forEach((input) =>
  input.addEventListener("blur", () => validerChamp(input)),
);


// --- Validation globale à la soumission du formulaire ---
// Empêche l'envoi si un champ est invalide, sinon simule un envoi réussi.
document.getElementById("form-inscription").addEventListener("submit", (e) => {
  e.preventDefault();

  let formulaireValide = true;

  inputs.forEach((input) => {
    if (!validerChamp(input)) formulaireValide = false;
  });

  if (!verifierCorrespondanceMdp()) formulaireValide = false;

  if (formulaireValide) {
    // Assemble l'indicatif et le numéro dans le champ numéro AVANT envoi
    const indicatif = (inputTelPrefix.value || "").trim();
    let numero = (inputTel.value || "").trim();
    // Retire l'indicatif déjà présent dans le numéro si besoin
    if (numero.startsWith(indicatif)) {
      numero = numero.slice(indicatif.length).trimStart();
    }
    inputTel.value = indicatif + numero;

    // Simule un envoi (désactive le bouton et affiche un message temporaire)
    const btn = document.getElementById("btn-submit");
    btn.textContent = "Envoi en cours…";
    btn.disabled = true;

    setTimeout(() => {
      btn.textContent = "Compte créé avec succès!";
    }, 1500);
  }
});

// --- Vérification de la correspondance des mots de passe ---
function verifierCorrespondanceMdp() {
  if (!passwordInput || !passwordConfirmInput) return true;
  const errEl = document.getElementById("erreur-password-confirm");
  const motDePasse = (passwordInput.value || "").trim();
  const confirmation = (passwordConfirmInput.value || "").trim();

  if (!confirmation) {
    if (errEl) errEl.textContent = "La confirmation est requise.";
    passwordConfirmInput.classList.add("invalide");
    passwordConfirmInput.classList.remove("valide");
    return false;
  }

  if (motDePasse !== confirmation) {
    if (errEl) errEl.textContent = "Les mots de passe ne correspondent pas.";
    passwordConfirmInput.classList.add("invalide");
    passwordConfirmInput.classList.remove("valide");
    return false;
  }

  if (errEl) errEl.textContent = "";
  passwordConfirmInput.classList.remove("invalide");
  passwordConfirmInput.classList.add("valide");
  return true;
}

if (passwordConfirmInput) {
  passwordConfirmInput.addEventListener("blur", verifierCorrespondanceMdp);
}
if (passwordInput) {
  passwordInput.addEventListener("input", verifierCorrespondanceMdp);
}

// --- Variables principales du formulaire ---
// Sélection des éléments du DOM nécessaires à la gestion dynamique du formulaire
const paysSelect = document.getElementById("pays"); // select des pays
const telInput = document.getElementById("tel"); // champ numéro de téléphone
const selectPays = paysSelect; // alias pour cohérence
const inputTelPrefix = document.getElementById("tel-prefix"); // champ indicatif
const inputTel = telInput; // alias
const dataUrl = "form-data.json"; // chemin du fichier de données
let prefixes = {}; // mapping code pays -> préfixe
let prefixIndex = []; // index pour la détection rapide du pays




// --- Synchronisation pays <-> indicatif <-> numéro ---
// Met à jour uniquement le champ indicatif quand on change de pays (plus de duplication dans le numéro)
paysSelect.addEventListener("change", () => {
  const opt = paysSelect.options[paysSelect.selectedIndex];
  if (!opt) return;
  const pref = opt.dataset?.prefix ?? "";
  if (pref) inputTelPrefix.value = pref;
});

// Détecte le pays automatiquement quand on saisit un numéro
telInput.addEventListener("input", () => {
  const paysDetecte = detecterPaysDepuisTel(telInput.value, prefixIndex);
  if (paysDetecte && paysSelect.value !== paysDetecte) {
    paysSelect.value = paysDetecte;
    // Met à jour l'indicatif affiché
    const opt = paysSelect.options[paysSelect.selectedIndex];
    if (opt) inputTelPrefix.value = opt.dataset?.prefix ?? "";
  }
});

// --- Chargement initial des données du formulaire (placeholders, options pays, préfixes) ---
// Remplit le select pays et initialise les mappings de préfixes à partir du JSON
({ prefixes, prefixIndex } = await chargerDonneesFormulaire(dataUrl, paysSelect, extrairePrefixeDuLabel, construirePrefixes));


// --- Synchronisation champ indicatif <-> select pays ---
// Quand on change le pays, on met à jour l'indicatif ; quand on tape un indicatif, on détecte le pays
if (selectPays && inputTelPrefix) {
  selectPays.addEventListener("change", () => {
    const opt = selectPays.options[selectPays.selectedIndex];
    if (!opt) return;
    const pref = opt.dataset?.prefix ?? "";
    if (pref) inputTelPrefix.value = pref;
  });
  inputTelPrefix.addEventListener("input", () => {
    const val = inputTelPrefix.value.split(/\s+/).join("");
    const pays = detecterPaysDepuisTel(val, prefixIndex) || chercherPaysParPrefixSimple(val, prefixIndex);
    if (pays) selectPays.value = pays;
  });
}
