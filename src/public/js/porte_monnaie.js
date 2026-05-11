document.addEventListener('DOMContentLoaded', () => {
  const getCookieValue = (name) => {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) {
      return parts.pop().split(';').shift();
    }
    return '';
  };

  const getCsrfToken = () => getCookieValue('csrf_cookie_name');

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
      const csrfToken = getCsrfToken();
      const response = await fetch('/ajax/code', {
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
        const csrfToken = getCsrfToken();
        const response = await fetch('/ajax/gold', {
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
