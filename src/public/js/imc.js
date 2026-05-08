document.addEventListener('DOMContentLoaded', () => {
  const taille = document.getElementById('taille');
  const poids = document.getElementById('poids');
  const output = document.getElementById('imc-preview-value');

  if (!taille || !poids || !output) {
    return;
  }

  const renderImc = () => {
    const tailleValue = parseFloat(taille.value);
    const poidsValue = parseFloat(poids.value);

    if (!tailleValue || !poidsValue || tailleValue <= 0) {
      output.textContent = 'Renseignez votre taille et votre poids pour voir une estimation.';
      return;
    }

    const tailleMetre = tailleValue / 100;
    const imc = poidsValue / (tailleMetre * tailleMetre);
    let categorie = 'Poids normal';

    if (imc < 18.5) {
      categorie = 'Insuffisance ponderale';
    } else if (imc >= 25 && imc < 30) {
      categorie = 'Surpoids';
    } else if (imc >= 30) {
      categorie = 'Obesite';
    }

    output.textContent = `IMC estime: ${imc.toFixed(2)} - ${categorie}`;
  };

  taille.addEventListener('input', renderImc);
  poids.addEventListener('input', renderImc);
  renderImc();
});
