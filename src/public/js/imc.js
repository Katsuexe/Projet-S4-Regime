document.addEventListener('DOMContentLoaded', () => {
  const csrfMeta = document.querySelector('meta[name="csrf-token"]');
  let csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

  const updateCsrfToken = (token) => {
    if (!token) {
      return;
    }

    csrfToken = token;
    if (csrfMeta) {
      csrfMeta.setAttribute('content', token);
    }
  };

  const page = document.querySelector('[data-imc-url]');
  const imcUrl = page?.dataset.imcUrl || '/ajax/imc';

  const taille = document.getElementById('taille');
  const poids = document.getElementById('poids');
  const output = document.getElementById('imc-preview-value');
  const live = document.getElementById('imc-live');
  const catLive = document.getElementById('imc-cat-live');

  if (!taille || !poids || (!output && !live && !catLive)) {
    return;
  }

  const setOutputMarkup = (markup) => {
    if (output) {
      output.innerHTML = markup;
      output.classList.remove('is-visible');
      requestAnimationFrame(() => {
        output.classList.add('is-visible');
      });
    }
  };

  const renderHint = (tone, title, message) => {
    setOutputMarkup(`
      <div class="imc-result imc-result--${tone}">
        <div class="imc-result-head">
          <span class="imc-chip imc-chip--${tone}">${title}</span>
        </div>
        <p class="imc-result-note">${message}</p>
      </div>
    `);
  };

  const resolveTone = (imcValue) => {
    if (imcValue < 18.5 || imcValue >= 30) {
      return 'alert';
    }

    if (imcValue < 25) {
      return 'good';
    }

    return 'warning';
  };

  const renderResult = (data) => {
    const imcValue = parseFloat(data.imc);
    const tone = resolveTone(imcValue);
    const title = tone === 'good'
      ? 'Bonne nouvelle'
      : tone === 'warning'
        ? 'Mise en garde'
        : 'Alerte';

    const summary = tone === 'good'
      ? 'Votre IMC est dans une zone equilibrée.'
      : tone === 'warning'
        ? 'Votre IMC demande un peu de vigilance.'
        : 'Votre IMC merite une attention particuliere.';

    setOutputMarkup(`
      <div class="imc-result imc-result--${tone}">
        <div class="imc-result-head">
          <span class="imc-chip imc-chip--${tone}">${title}</span>
          <span class="imc-chip imc-chip--neutral">${data.categorie}</span>
        </div>
        <div class="imc-result-main">
          <div>
            <p class="imc-result-label">IMC estime</p>
            <p class="imc-result-value">${data.imc}</p>
          </div>
          <div class="imc-result-metrics">
            <div class="imc-metric">
              <span class="imc-metric-label">Poids ideal</span>
              <strong>${data.poids_ideal} kg</strong>
            </div>
            <div class="imc-metric">
              <span class="imc-metric-label">Fourchette ideale</span>
              <strong>${data.fourchette_ideale}</strong>
            </div>
          </div>
        </div>
        <p class="imc-result-note">${summary}</p>
      </div>
    `);
  };

  const renderImc = async () => {
    const tailleValue = parseFloat(taille.value);
    const poidsValue = parseFloat(poids.value);

    if (!tailleValue || !poidsValue || tailleValue <= 0) {
      renderHint('neutral', 'En attente', 'Renseignez votre taille et votre poids pour voir une estimation.');
      return;
    }

    if (tailleValue < 100 || tailleValue > 250 || poidsValue < 30 || poidsValue > 300) {
      renderHint('warning', 'Mise en garde', 'Saisissez une taille entre 100 et 250 cm et un poids entre 30 et 300 kg.');
      return;
    }

    try {
      renderHint('neutral', 'Calcul en cours', 'Nous mettons a jour votre estimation IMC...');
      const response = await fetch(imcUrl, {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
          ...(csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {}),
        },
        body: JSON.stringify({
          taille: tailleValue,
          poids: poidsValue,
        }),
      });

      const data = await response.json();
      if (data?.csrf) {
        updateCsrfToken(data.csrf);
      }

      if (!response.ok || !data?.success) {
        throw new Error(data?.message || 'IMC request failed');
      }

      renderResult(data);

      if (live) {
        live.textContent = data.imc;
      }

      if (catLive) {
        catLive.textContent = data.categorie;
        catLive.className = `imc-cat ${data.couleur || (data.imc < 18.5 || data.imc >= 30 ? 'obese' : (data.imc < 25 ? 'normal' : 'surpoid'))}`;
      }
    } catch (error) {
      renderHint('alert', 'Alerte', 'Impossible de calculer l IMC pour le moment.');
    }
  };

  taille.addEventListener('input', renderImc);
  poids.addEventListener('input', renderImc);
  renderImc();
});
