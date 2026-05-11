<?= $this->extend('layouts/front') ?>

<?= $this->section('content') ?>
<?php
$codeHistory = $codeHistory ?? [];
$goldPrice = $goldPrice ?? 29.99;
?>
<div class="page-content" data-redeem-url="<?= site_url('ajax/code') ?>" data-gold-url="<?= site_url('ajax/gold') ?>" data-gold-price="<?= esc(number_format((float) $goldPrice, 2, '.', '')) ?>">
    <div class="page-header">
        <div class="page-header-text">
            <div class="kicker">Mon compte</div>
            <h1>Mon portefeuille</h1>
            <p>Rechargez votre solde avec un code, puis utilisez ce solde directement au moment de souscrire a un regime.</p>
        </div>
    </div>

    <?= view('partials/flash_messages') ?>

    <div class="wallet-hero">
        <div class="wallet-balance">
            <div class="lbl">Solde disponible</div>
            <div class="amount"><?= esc(number_format((float) (session('solde') ?? 0), 2, ',', ' ')) ?> Ar</div>
        </div>
        <div class="wallet-gold">
            <div class="gl"><?= ! empty(session('is_gold')) ? '⭐ Statut Gold actif' : 'Pass Gold disponible' ?></div>
            <?php if (! empty(session('is_gold'))): ?>
                <div style="font-size:.85rem;opacity:.85">-15% sur tous les regimes</div>
            <?php else: ?>
                <button class="btn-gold" id="btn-activate-gold" type="button">Activer Gold (<?= esc(number_format((float) $goldPrice, 2, ',', ' ')) ?> Ar)</button>
            <?php endif; ?>
        </div>
    </div>

    <div class="card" style="margin-bottom:24px">
        <div class="card-head">Utiliser un code portefeuille</div>
        <div class="card-body">
            <div class="code-input-wrap">
                <input type="text" id="code-input" placeholder="EX : PROMO-2026-ABCD" maxlength="30">
                <button class="btn-primary" id="btn-valider" type="button">Valider le code</button>
            </div>
            <div class="code-result" id="code-result"></div>
        </div>
    </div>

    <div class="card">
        <div class="card-head">Historique de mes codes utilises</div>
        <div class="card-body">
            <?php if (empty($codeHistory)): ?>
                <p id="code-history-empty">Aucun code utilise pour le moment.</p>
                <table class="history-table" id="code-history-table" style="display:none">
            <?php else: ?>
                <table class="history-table" id="code-history-table">
            <?php endif; ?>
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Montant</th>
                        <th>Date d'utilisation</th>
                    </tr>
                </thead>
                <tbody id="code-history-body">
                    <?php foreach ($codeHistory as $history): ?>
                        <tr>
                            <td><code><?= esc((string) ($history['code'] ?? '')) ?></code></td>
                            <td><?= esc(number_format((float) ($history['montant'] ?? 0), 2, ',', ' ')) ?> Ar</td>
                            <td><?= esc((string) ($history['used_at'] ?? '-')) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card" style="margin-top:24px">
        <div class="card-head">Ce que vous pouvez faire ici</div>
        <div class="card-body">
            <table class="history-table" id="actions-table">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Utilite</th>
                        <th>Quand l'utiliser</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Entrer un code</td>
                        <td>Ajouter du solde a votre compte</td>
                        <td>Avant de souscrire a un nouveau programme</td>
                    </tr>
                    <tr>
                        <td>Verifier le solde</td>
                        <td>Savoir si la souscription est possible</td>
                        <td>Au moment de comparer les regimes</td>
                    </tr>
                    <tr>
                        <td>Activer Gold</td>
                        <td>Profiter d'une remise automatique</td>
                        <td>Si vous prevoyez plusieurs souscriptions</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="<?= base_url('js/porte_monnaie.js') ?>"></script>
<?= $this->endSection() ?>