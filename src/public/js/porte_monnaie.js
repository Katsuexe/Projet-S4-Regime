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

  const page = document.querySelector('[data-redeem-url]');
  const redeemUrl = page?.dataset.redeemUrl || '/ajax/code';
  const goldUrl = page?.dataset.goldUrl || '/ajax/gold';

  const button = document.getElementById('btn-valider');
  const input = document.getElementById('code-input');
  const result = document.getElementById('code-result');

  if (!button || !input || !result) {
    return;
  }

  button.addEventListener('click', async () => {
    const code = input.value.trim();

    if (!code) {
      result.className = 'code-result error';
      result.textContent = 'Veuillez saisir un code.';
      return;
    }

    try {
      const response = await fetch(redeemUrl, {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
          ...(csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {}),
        },
        body: JSON.stringify({ code }),
      });

      const data = await response.json();
      if (data?.csrf) {
        updateCsrfToken(data.csrf);
      }
      result.className = `code-result ${data.success ? 'success' : 'error'}`;
      result.textContent = data.success
        ? `+${data.montant} ajoutes. Nouveau solde : ${data.solde} Ar`
        : data.message;

      if (data.success) {
        // Update navbar balance
        const amountEl = document.querySelector('.navbar-wallet .amount');
        if (amountEl) {
          amountEl.textContent = `${parseFloat(data.solde).toFixed(2).replace('.', ',')} Ar`;
        }
      }
    } catch (error) {
      result.className = 'code-result error';
      result.textContent = 'Erreur lors de la validation du code.';
    }
  });

  // Gold activation
  const goldButton = document.getElementById('btn-activate-gold');
  if (goldButton) {
    goldButton.addEventListener('click', async () => {
      if (!confirm('Confirmer l\'activation de Gold pour 29,99 Ar ?')) {
        return;
      }

      try {
        const response = await fetch(goldUrl, {
          method: 'POST',
          credentials: 'same-origin',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            ...(csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {}),
          },
          body: JSON.stringify({}),
        });

        const data = await response.json();
        if (data?.csrf) {
          updateCsrfToken(data.csrf);
        }

        if (data.success) {
          alert(data.message);
          // Update navbar balance
          const amountEl = document.querySelector('.navbar-wallet .amount');
          if (amountEl) {
            amountEl.textContent = `${parseFloat(data.solde).toFixed(2).replace('.', ',')} Ar`;
          }
          // Reload to update Gold status
          location.reload();
        } else {
          alert(data.message);
        }
      } catch (error) {
        alert('Erreur lors de l\'activation Gold.');
      }
    });
  }
});
