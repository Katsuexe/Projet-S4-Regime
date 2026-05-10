<?= $this->extend('layouts/front') ?>

<?= $this->section('content') ?>
<div class="page-content">
    <?= view('partials/flash_messages') ?>

    <div class="page-header">
        <div class="page-header-text">
            <div class="kicker">Bonjour <?= esc($user['prenom'] ?? session('user_prenom') ?? 'Sportif') ?></div>
            <h1>Suggestions adaptees a votre objectif</h1>
            <p>Nous avons retenu des regimes simples a comprendre, avec les durees, le prix et l'activite conseillee pour vous aider a choisir vite.</p>
        </div>

        <div class="imc-widget">
            <div class="title">Votre IMC</div>
            <div class="imc-value"><?= esc(number_format((float) ($imc ?? 0), 1, '.', '')) ?></div>
            <?php
            $categorieClass = 'normal';
            if (($imc ?? 0) >= 25 && ($imc ?? 0) < 30) {
                $categorieClass = 'surpoid';
            } elseif (($imc ?? 0) < 18.5 || ($imc ?? 0) >= 30) {
                $categorieClass = 'obese';
            }
            ?>
            <span class="imc-cat <?= esc($categorieClass) ?>"><?= esc(\App\Libraries\ImcCalculator::categorie((float) ($imc ?? 0))) ?></span>
            <div class="imc-ideal">Objectif : <?= esc($sante['objectif'] ?? '-') ?></div>
        </div>
    </div>

    <div class="section-title">Regimes proposes</div>
    <div class="regimes-grid">
        <?php foreach ($regimes as $regime): ?>
            <?php
            $tag = 'ideal';
            $tagLabel = 'IMC ideal';
            $deltaMin = (float) ($regime['delta_poids_min'] ?? 0);
            $deltaMax = (float) ($regime['delta_poids_max'] ?? 0);

            if ($deltaMin >= 0 && $deltaMax >= 0) {
                $tag = 'augmenter';
                $tagLabel = '↑ Prise de masse';
            } elseif ($deltaMin <= 0 && $deltaMax <= 0) {
                $tag = 'reduire';
                $tagLabel = '↓ Perte de poids';
            }

            $firstPrice = ! empty($regime['durees']) ? (float) $regime['durees'][0]['prix'] : 0.0;
            $firstDiscount = \App\Libraries\RegimeSuggestor::applyGoldDiscount($firstPrice, (bool) ($user['is_gold'] ?? false));
            $insufficient = (float) ($user['solde'] ?? 0) < $firstDiscount;
            ?>
            <div class="regime-card">
                <div class="regime-card-head" style="display:flex;align-items:flex-start;gap:10px;flex-wrap:wrap">
                    <h2><?= esc($regime['nom']) ?></h2>
                    <span class="regime-tag <?= esc($tag) ?>"><?= esc($tagLabel) ?></span>
                    <?php if (! empty($regime['hasActiveSubscription'])): ?>
                        <span style="font-size:.75rem;padding:4px 10px;border-radius:999px;background:#0f766e;color:#fff;">Actif</span>
                    <?php endif; ?>
                </div>
                <div class="regime-card-body">
                    <p class="regime-desc"><?= esc($regime['description'] ?? '') ?></p>

                    <div>
                        <div class="compo-label">Composition</div>
                        <div class="compo-bars">
                            <div class="compo-row">
                                <span class="compo-name">Viande</span>
                                <div class="compo-bar-track"><div class="compo-bar-fill" style="width:<?= esc((string) $regime['pct_viande']) ?>%;background:var(--viande)"></div></div>
                                <span class="compo-pct"><?= esc((string) $regime['pct_viande']) ?>%</span>
                            </div>
                            <div class="compo-row">
                                <span class="compo-name">Poisson</span>
                                <div class="compo-bar-track"><div class="compo-bar-fill" style="width:<?= esc((string) $regime['pct_poisson']) ?>%;background:var(--poisson)"></div></div>
                                <span class="compo-pct"><?= esc((string) $regime['pct_poisson']) ?>%</span>
                            </div>
                            <div class="compo-row">
                                <span class="compo-name">Volaille</span>
                                <div class="compo-bar-track"><div class="compo-bar-fill" style="width:<?= esc((string) $regime['pct_volaille']) ?>%;background:var(--volaille)"></div></div>
                                <span class="compo-pct"><?= esc((string) $regime['pct_volaille']) ?>%</span>
                            </div>
                        </div>
                    </div>

                    <div class="delta-poids">
                        <span class="label">Variation attendue</span>
                        <span class="value"><?= esc((string) $regime['delta_poids_min']) ?> a <?= esc((string) $regime['delta_poids_max']) ?> kg</span>
                    </div>

                    <form action="<?= site_url('souscrire') ?>" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="regime_id" value="<?= esc((string) $regime['id']) ?>">

                        <div class="duration-label">Choisir une duree</div>
                        <div class="duration-pills">
                            <?php foreach ($regime['durees'] as $index => $duree): ?>
                                <?php
                                $radioId = 'duree-' . $regime['id'] . '-' . $duree['id'];
                                $prixBrut = (float) $duree['prix'];
                                $prixNet = \App\Libraries\RegimeSuggestor::applyGoldDiscount($prixBrut, (bool) ($user['is_gold'] ?? false));
                                ?>
                                <input class="pill-input" type="radio" name="regime_duree_id" id="<?= esc($radioId) ?>" value="<?= esc((string) $duree['id']) ?>" <?= $index === 0 ? 'checked' : '' ?>>
                                <label class="pill-label" for="<?= esc($radioId) ?>">
                                    <span class="days"><?= esc((string) $duree['duree_jours']) ?> j</span>
                                    <span class="price"><?= esc(number_format($prixNet, 2, ',', ' ')) ?> Ar</span>
                                    <?php if (! empty($user['is_gold'])): ?>
                                        <span class="price-gold"><?= esc(number_format($prixBrut, 2, ',', ' ')) ?> Ar</span>
                                    <?php endif; ?>
                                </label>
                            <?php endforeach; ?>
                        </div>

                        <?php if (! empty($activites)): ?>
                            <div class="form-group" style="margin-top:14px;margin-bottom:0">
                                <label for="activite-<?= esc((string) $regime['id']) ?>">Activite conseillee</label>
                                <select id="activite-<?= esc((string) $regime['id']) ?>" name="activite_id">
                                    <option value="">Sans activite complementaire</option>
                                    <?php foreach ($activites as $activite): ?>
                                        <option value="<?= esc((string) $activite['id']) ?>"><?= esc($activite['nom']) ?> - <?= esc((string) $activite['duree_min']) ?> min/jour</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endif; ?>

                        <div class="regime-card-foot" style="padding:16px 0 0">
                            <button type="submit" class="btn-subscribe <?= $insufficient ? 'disabled' : '' ?>" <?= $insufficient ? 'disabled' : '' ?>>
                                Souscrire au programme
                            </button>
                            <?php if ($insufficient): ?>
                                <div class="solde-warning">Solde insuffisant. Rechargez votre portefeuille avant de confirmer.</div>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="section-title">Activites recommandees</div>
    <div class="regimes-grid">
        <?php foreach ($activites as $activite): ?>
            <div class="card">
                <div class="card-body">
                    <h3 style="font-size:1rem;margin-bottom:8px"><?= esc($activite['nom']) ?></h3>
                    <p style="color:var(--text-3);line-height:1.6;margin-bottom:14px"><?= esc($activite['description'] ?? '') ?></p>
                    <div class="profil-stats">
                        <div class="profil-stat"><div class="val"><?= esc((string) ($activite['calories_h'] ?? 0)) ?></div><div class="lbl">Calories/h</div></div>
                        <div class="profil-stat"><div class="val"><?= esc((string) ($activite['duree_min'] ?? 0)) ?> min</div><div class="lbl">Duree</div></div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?= $this->endSection() ?>
