document.addEventListener('DOMContentLoaded', () => {
  const taille = document.getElementById('taille');
  const poids = document.getElementById('poids');
  const output = document.getElementById('imc-preview-value');
  const live = document.getElementById('imc-live');
  const catLive = document.getElementById('imc-cat-live');

  if (!taille || !poids || !output) {
    return;
  }

  const renderImc = async () => {
    const tailleValue = parseFloat(taille.value);
    const poidsValue = parseFloat(poids.value);

    if (!tailleValue || !poidsValue || tailleValue <= 0) {
      output.textContent = 'Renseignez votre taille et votre poids.';
      return;
    }

    try {
      const response = await fetch('/ajax/imc', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({
          taille: tailleValue,
          poids: poidsValue,
        }),
      });

      if (!response.ok) {
        throw new Error('IMC request failed');
      }

      const data = await response.json();
      output.textContent = `IMC estime : ${data.imc} - ${data.categorie} - Poids ideal : ${data.poids_ideal} kg`;

      if (live) {
        live.textContent = data.imc;
      }

      if (catLive) {
        catLive.textContent = data.categorie;
        catLive.className = `imc-cat ${data.imc < 18.5 || data.imc >= 30 ? 'obese' : (data.imc < 25 ? 'normal' : 'surpoid')}`;
      }
    } catch (error) {
      output.textContent = 'Impossible de calculer l IMC pour le moment.';
    }
  };

  taille.addEventListener('input', renderImc);
  poids.addEventListener('input', renderImc);
  renderImc();
});
