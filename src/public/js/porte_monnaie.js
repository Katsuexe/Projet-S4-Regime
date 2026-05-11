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
  const goldPrice = parseFloat(page?.dataset.goldPrice || '29.99');

  const button = document.getElementById('btn-valider');
  const input = document.getElementById('code-input');
  const result = document.getElementById('code-result');
  const historyTable = document.getElementById('code-history-table');
  const historyBody = document.getElementById('code-history-body');
  const historyEmpty = document.getElementById('code-history-empty');
  const redeemIdleText = button ? button.textContent.trim() : 'Valider le code';

  if (!button || !input || !result) {
    return;
  }

  const setLoading = (targetButton, isLoading, loadingText, idleText) => {
    targetButton.disabled = isLoading;
    targetButton.classList.toggle('is-loading', isLoading);
    targetButton.dataset.idleText = idleText;
    targetButton.innerHTML = isLoading
      ? `<span class="spinner-inline" aria-hidden="true"></span>${loadingText}`
      : idleText;
  };

  const formatAr = (value) => `${parseFloat(value).toFixed(2).replace('.', ',')} Ar`;

  const prependHistoryRow = (data) => {
    if (!historyBody) {
      return;
    }

    if (historyEmpty) {
      historyEmpty.style.display = 'none';
    }

    if (historyTable) {
      historyTable.style.display = '';
    }

    const row = document.createElement('tr');
    const codeCell = document.createElement('td');
    const codeTag = document.createElement('code');
    codeTag.textContent = data.code;
    codeCell.appendChild(codeTag);

    const amountCell = document.createElement('td');
    amountCell.textContent = formatAr(data.montant);

    const dateCell = document.createElement('td');
    dateCell.textContent = data.used_at;

    row.appendChild(codeCell);
    row.appendChild(amountCell);
    row.appendChild(dateCell);
    historyBody.prepend(row);
  };

  button.addEventListener('click', async () => {
    const code = input.value.trim();

    if (!code) {
      result.className = 'code-result error';
      result.textContent = 'Veuillez saisir un code.';
      return;
    }

    try {
      setLoading(button, true, 'Validation...', redeemIdleText);
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
        input.value = '';
        // Update navbar balance
        const amountEl = document.querySelector('.navbar-wallet .amount');
        if (amountEl) {
          amountEl.textContent = formatAr(data.solde);
        }
        prependHistoryRow(data);
      }
    } catch (error) {
      result.className = 'code-result error';
      result.textContent = 'Erreur lors de la validation du code.';
    } finally {
      setLoading(button, false, 'Validation...', redeemIdleText);
    }
  });

  // Gold activation
  const goldButton = document.getElementById('btn-activate-gold');
  if (goldButton) {
    const goldIdleText = goldButton.textContent.trim();
    goldButton.addEventListener('click', async () => {
      if (!confirm(`Confirmer l'activation de Gold pour ${formatAr(goldPrice)} ?`)) {
        return;
      }

      try {
        setLoading(goldButton, true, 'Activation...', goldIdleText);
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
            amountEl.textContent = formatAr(data.solde);
          }
          // Reload to update Gold status
          location.reload();
        } else {
          alert(data.message);
        }
      } catch (error) {
        alert('Erreur lors de l\'activation Gold.');
      } finally {
        setLoading(goldButton, false, 'Activation...', goldIdleText);
      }
    });
  }
});
