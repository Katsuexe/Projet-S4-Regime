<?= $this->extend('layouts/front') ?>

<?= $this->section('content') ?>
<?php $errors = session('errors') ?? []; ?>
<div class="page-content">
    <?= view('partials/flash_messages') ?>
    <div class="page-header">
        <div class="page-header-text">
            <div class="kicker">Votre programme</div>
            <h1>Quel est votre objectif ?</h1>
            <p>Ce choix permet de filtrer tout de suite les regimes les plus utiles pour votre situation.</p>
        </div>
    </div>

    <form action="<?= site_url('objectif') ?>" method="post">
        <?= csrf_field() ?>
        <div class="objectif-grid">
            <?php $current = old('objectif', $objectifActuel ?? ''); ?>
            <label class="objectif-card <?= $current === 'augmenter' ? 'selected' : '' ?>">
                <input type="radio" name="objectif" value="augmenter" <?= $current === 'augmenter' ? 'checked' : '' ?> hidden>
                <div class="check"></div>
                <div class="objectif-icon up">💪</div>
                <div class="objectif-title">Augmenter ma masse</div>
                <p class="objectif-desc">Des programmes plus riches pour soutenir la prise de poids et la masse musculaire.</p>
                <span class="objectif-tag" style="background:var(--green-light);color:var(--green)">+0.3 a +1.0 kg</span>
            </label>
            <label class="objectif-card <?= $current === 'reduire' ? 'selected' : '' ?>">
                <input type="radio" name="objectif" value="reduire" <?= $current === 'reduire' ? 'checked' : '' ?> hidden>
                <div class="check"></div>
                <div class="objectif-icon down">🔥</div>
                <div class="objectif-title">Reduire mon poids</div>
                <p class="objectif-desc">Des choix plus legers et plus progressifs pour perdre sans se compliquer.</p>
                <span class="objectif-tag" style="background:var(--blue-light);color:var(--blue)">-0.5 a -2.0 kg</span>
            </label>
            <label class="objectif-card <?= $current === 'ideal' ? 'selected' : '' ?>">
                <input type="radio" name="objectif" value="ideal" <?= $current === 'ideal' ? 'checked' : '' ?> hidden>
                <div class="check"></div>
                <div class="objectif-icon ideal">⚖️</div>
                <div class="objectif-title">Atteindre un IMC ideal</div>
                <p class="objectif-desc">Un equilibre alimentaire stable pour se rapprocher d'un poids de forme durable.</p>
                <span class="objectif-tag" style="background:var(--amber-light);color:var(--amber)">IMC 18.5 - 24.9</span>
            </label>
        </div>
        <?php if (! empty($errors['objectif'])): ?>
            <div class="flash flash-error"><?= is_array($errors['objectif']) ? esc(implode('<br>', $errors['objectif'])) : esc($errors['objectif']) ?></div>
        <?php endif; ?>
        <div class="action-row">
            <a href="<?= site_url('profil') ?>" class="btn-outline">Retour au profil</a>
            <button type="submit" class="btn-primary">Enregistrer l'objectif</button>
        </div>
    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const cards = document.querySelectorAll('.objectif-card');
    cards.forEach((card) => {
        card.addEventListener('click', () => {
            cards.forEach((item) => item.classList.remove('selected'));
            card.classList.add('selected');
        });
    });
});
</script>
<?= $this->endSection() ?>