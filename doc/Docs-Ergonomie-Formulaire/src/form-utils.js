// --- Fonctions d'initialisation et de gestion du formulaire principal ---

/**
 * Construit l'index des préfixes à partir des options du select pays (DOM).
 * Utile si on veut reconstruire dynamiquement l'index à partir du select.
 * @param {HTMLSelectElement} paysSelect - Le select des pays.
 * @param {function} extrairePrefixeDuLabel - Fonction pour extraire le préfixe du label.
 * @param {function} construirePrefixes - Fonction pour construire l'index des préfixes.
 * @returns {Object} prefixes et prefixIndex
 */
export function construirePrefixesDepuisSelect(paysSelect, extrairePrefixeDuLabel, construirePrefixes) {
  const options = Array.from(paysSelect.options)
    .filter((option) => option?.value)
    .map((option) => ({
      value: option.value,
      prefix: extrairePrefixeDuLabel(option.textContent),
    }));
  return construirePrefixes(options);
}

/**
 * Applique les données du JSON au formulaire : placeholders, options pays, index des préfixes.
 * Remplit le select, les placeholders, et retourne les mappings utiles.
 * @param {Object} data - Données du JSON.
 * @param {HTMLSelectElement} paysSelect - Le select des pays.
 * @param {function} extrairePrefixeDuLabel - Fonction pour extraire le préfixe du label.
 * @param {function} construirePrefixes - Fonction pour construire l'index des préfixes.
 * @returns {Object} prefixes et prefixIndex
 */
export function appliquerDonneesFormulaire(data, paysSelect, extrairePrefixeDuLabel, construirePrefixes) {
  let prefixes = {};
  let prefixIndex = [];
  if (data?.placeholders) {
    Object.entries(data.placeholders).forEach(([id, placeholder]) => {
      const champ = document.getElementById(id);
      if (champ && placeholder) champ.setAttribute("placeholder", placeholder);
    });
  }
  const paysData = data?.selects?.pays;
  if (Array.isArray(paysData?.options)) {
    paysSelect.innerHTML = "";
    const emptyOption = document.createElement("option");
    emptyOption.value = "";
    emptyOption.textContent = paysData.emptyLabel || "— Sélectionner —";
    paysSelect.appendChild(emptyOption);
    paysData.options.forEach((option) => {
      if (!option?.value || !option?.name || !option?.prefix) return;
      const opt = document.createElement("option");
      opt.value = option.value;
      const cleanedPrefix = option.prefix.split(/\s+/).join("").trim();
      opt.dataset.prefix = cleanedPrefix;
      opt.textContent = `${option.name} (${cleanedPrefix})`; // Affiche le nom et le préfixe dans le label
      paysSelect.appendChild(opt);
    });
    const res = construirePrefixes(paysData.options);
    prefixes = res.prefixes;
    prefixIndex = res.prefixIndex;
  } else {
    const res = construirePrefixesDepuisSelect(paysSelect, extrairePrefixeDuLabel, construirePrefixes);
    prefixes = res.prefixes;
    prefixIndex = res.prefixIndex;
  }
  return { prefixes, prefixIndex };
}

/**
 * Charge le JSON de configuration du formulaire, applique les données et retourne les index de préfixes.
 * @param {string} dataUrl - Chemin du fichier JSON.
 * @param {HTMLSelectElement} paysSelect - Le select des pays.
 * @param {function} extrairePrefixeDuLabel - Fonction pour extraire le préfixe du label.
 * @param {function} construirePrefixes - Fonction pour construire l'index des préfixes.
 * @returns {Promise<Object>} prefixes et prefixIndex
 */
export async function chargerDonneesFormulaire(dataUrl, paysSelect, extrairePrefixeDuLabel, construirePrefixes) {
  try {
    const response = await fetch(dataUrl, { cache: "no-store" });
    if (!response.ok) {
      throw new Error("Reponse invalide: " + response.status);
    }
    const data = await response.json();
    return appliquerDonneesFormulaire(data, paysSelect, extrairePrefixeDuLabel, construirePrefixes);
  } catch (error) {
    console.error("Impossible de charger les donnees du formulaire.", error);
    return construirePrefixesDepuisSelect(paysSelect, extrairePrefixeDuLabel, construirePrefixes);
  }
}

/**
 * Met à jour le champ numéro de téléphone en fonction du pays sélectionné.
 * Si l'utilisateur change de pays, l'indicatif est mis à jour dans le champ numéro.
 * @param {HTMLSelectElement} paysSelect
 * @param {HTMLInputElement} telInput
 * @param {Object} prefixes - mapping code pays -> préfixe
 * @param {function} normaliserTel - fonction de normalisation du numéro
 */
export function mettreAJourPrefixeTel(paysSelect, telInput, prefixes, normaliserTel) {
  const nouveauPrefixe = prefixes[paysSelect.value];
  if (!nouveauPrefixe) return;
  const valeurActuelle = normaliserTel(telInput.value);
  if (!valeurActuelle) {
    telInput.value = nouveauPrefixe;
    return;
  }
  const prefixeConnu = Object.values(prefixes)
    .map((prefixe) => prefixe.trim())
    .find((prefixe) => valeurActuelle.startsWith(prefixe));
  let reste = valeurActuelle;
  if (prefixeConnu) {
    reste = valeurActuelle.slice(prefixeConnu.length).trimStart();
  }
  if (reste.startsWith("+")) {
    reste = reste.slice(1).trimStart();
  }
  telInput.value = nouveauPrefixe + reste;
}
// --- Fonctions de validation des champs du formulaire ---
/**
 * Règles de validation pour chaque champ du formulaire.
 * Utilisé par validerChamp.
 */
const regles = {
  nom: { requis: true, message: "Le nom est requis." },
  prenom: { requis: true, message: "Le prénom est requis." },
  ddn: { requis: true, message: "La date de naissance est requise." },
  email: {
    requis: true,
    tester: (v) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v),
    message: "Adresse email invalide."
  },
  password: {
    requis: true,
    tester: (v) => v.length >= 8,
    message: "Le mot de passe doit contenir au moins 8 caractères."
  }
};

/**
 * Valide un champ selon les règles définies.
 * Affiche le message d'erreur si besoin et ajoute les classes CSS.
 * @param {HTMLElement} champ - L'input à valider
 * @returns {boolean} true si valide, false sinon
 */
export function validerChamp(champ) {
  const regle = regles[champ.id];
  if (!regle) return true;
  const valeur = champ.value.trim();
  const erreurEl = document.getElementById("erreur-" + champ.id);
  let message = "";
  if ((regle.requis && !valeur) || (valeur && regle.tester && !regle.tester(valeur))) {
    message = regle.message;
  }
  if (erreurEl) erreurEl.textContent = message;
  champ.classList.toggle("invalide", !!message);
  champ.classList.toggle("valide", !message && !!valeur);
  return !message;
}

// --- Fonctions liées aux préfixes téléphoniques ---
/**
 * Construit le mapping des préfixes et l'index pour la détection rapide.
 * @param {Array} options - Liste des pays avec préfixes
 * @returns {Object} prefixes et prefixIndex
 */
export function construirePrefixes(options) {
  const prefixes = {};
  const prefixIndex = [];
  options.forEach((option) => {
    if (!option?.value || !option?.prefix) return;
    const prefixeNettoye = option.prefix.split(/\s+/).join("").trim();
    if (!prefixeNettoye) return;
    prefixes[option.value] = prefixeNettoye + " ";
    prefixIndex.push({ pays: option.value, prefixe: prefixeNettoye });
  });
  prefixIndex.sort((a, b) => b.prefixe.length - a.prefixe.length);
  return { prefixes, prefixIndex };
}

/**
 * Extrait le préfixe d'un label d'option (ex: "(+33) France" -> "+33").
 * @param {string} label
 * @returns {string}
 */
export function extrairePrefixeDuLabel(label) {
  const match = /\((\+\d+)\)/.exec(label ?? "");
  return match ? match[1] : "";
}

/**
 * Normalise un numéro de téléphone (supprime espaces multiples).
 * @param {string} valeur
 * @returns {string}
 */
export function normaliserTel(valeur) {
  return valeur.split(/\s+/).join(" ").trim();
}

/**
 * Détecte le pays à partir d'un numéro saisi (en cherchant le préfixe).
 * @param {string} valeur - numéro saisi
 * @param {Array} prefixIndex - index des préfixes
 * @returns {string|null} code pays ou null
 */
export function detecterPaysDepuisTel(valeur, prefixIndex) {
  const nettoyee = valeur.split(/\s+/).join("").trim();
  if (!nettoyee) return null;
  const match = prefixIndex.find((item) => nettoyee.startsWith(item.prefixe));
  return match ? match.pays : null;
}

/**
 * Détecte le pays à partir d'un préfixe saisi (avec ou sans '+').
 * @param {string} val - préfixe saisi
 * @param {Array} prefixIndex - index des préfixes
 * @returns {string|null} code pays ou null
 */
export function chercherPaysParPrefixSimple(val, prefixIndex) {
  if (!val) return null;
  const withPlus = val.startsWith("+") ? val : "+" + val;
  const match = prefixIndex.find((item) => withPlus.startsWith(item.prefixe));
  return match ? match.pays : null;
}

/**
 * Trouve le pays correspondant à un préfixe exact ou avec '+'.
 * @param {string} prefix
 * @param {Object} prefixes
 * @returns {string|null}
 */
export function chercherPaysParPrefixExact(prefix, prefixes) {
  if (!prefix) return null;
  const normalise = prefix.trim();
  return prefixes[normalise] || prefixes["+" + normalise] || null;
}
