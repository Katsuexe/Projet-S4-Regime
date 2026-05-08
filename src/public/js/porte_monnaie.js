document.addEventListener('DOMContentLoaded', () => {
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
      const response = await fetch('/ajax/code', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({ code }),
      });

      const data = await response.json();
      result.className = `code-result ${data.success ? 'success' : 'error'}`;
      result.textContent = data.success
        ? `+${data.montant} ajoutes. Nouveau solde : ${data.solde} Ar`
        : data.message;
    } catch (error) {
      result.className = 'code-result error';
      result.textContent = 'Erreur lors de la validation du code.';
    }
  });
});
