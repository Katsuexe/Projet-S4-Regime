-- ============================================================
--  SCRIPT 2 : DONNÉES INDISPENSABLES
--  (paramètres, régimes, forfaits, activités)
-- ============================================================

USE `regime_s4`;

-- Paramètres
INSERT INTO `parametres` (`cle`, `valeur`) VALUES
  ('prix_gold',       '29.99'),
  ('remise_gold_pct', '15'),
  ('imc_ideal_min',   '18.5'),
  ('imc_ideal_max',   '24.9'),
  ('imc_surpoids',    '25.0'),
  ('imc_obesite',     '30.0');

-- Régimes (5)
INSERT INTO `regimes` (`nom`, `description`, `pct_viande`, `pct_poisson`, `pct_volaille`, `delta_poids_min`, `delta_poids_max`) VALUES
  ('Méditerranéen', 'Inspiré des pays du bassin méditerranéen, riche en poisson, légumes et huile d\'olive. Idéal pour atteindre un IMC équilibré.',
   20.00, 40.00, 40.00, -0.50, 0.20),
  ('Hyperprotéiné', 'Régime riche en protéines animales favorisant la prise de masse musculaire et l\'augmentation du poids corporel.',
   50.00, 20.00, 30.00, 0.30, 1.00),
  ('Hypocalorique', 'Régime à faible apport calorique basé sur la volaille maigre et le poisson pour une perte de poids progressive.',
   15.00, 35.00, 50.00, -1.50, -0.30),
  ('Cétogène', 'Très faible en glucides, très riche en protéines et lipides. Favorise une perte de poids rapide par cétose.',
   60.00, 10.00, 30.00, -2.00, -0.50),
  ('Flexitarien marin', 'Priorité au poisson et à la volaille, viande réduite au minimum. Équilibré et durable pour maintenir l\'IMC idéal.',
   5.00, 55.00, 40.00, -0.80, 0.10);

-- Prix par durée (4 par régime = 20 entrées)
INSERT INTO `regime_durees` (`regime_id`, `duree_jours`, `prix`) VALUES
  (1,  7,   9.99), (1, 14,  17.99), (1, 30,  29.99), (1, 60,  49.99),
  (2,  7,  12.99), (2, 14,  22.99), (2, 30,  39.99), (2, 60,  69.99),
  (3,  7,   8.99), (3, 14,  15.99), (3, 30,  27.99), (3, 60,  44.99),
  (4,  7,  14.99), (4, 14,  26.99), (4, 30,  44.99), (4, 60,  79.99),
  (5,  7,  10.99), (5, 14,  19.99), (5, 30,  34.99), (5, 60,  59.99);

-- Activités sportives (5)
INSERT INTO `activites` (`nom`, `description`, `calories_h`, `duree_min`) VALUES
  ('Marche rapide', 'Activité accessible à tous, idéale pour commencer. Améliore le système cardiovasculaire et favorise la perte de poids progressive.',
   300, 45),
  ('Natation', 'Sport complet sollicitant tous les groupes musculaires. Très efficace pour brûler des calories sans impact articulaire.',
   550, 45),
  ('Musculation', 'Entraînement en résistance pour développer la masse musculaire. Recommandé en complément d\'un régime hyperprotéiné.',
   400, 60),
  ('Vélo / Cyclisme', 'Activité cardio d\'endurance. Adaptée à tous les niveaux pour entretenir la forme et perdre du poids en douceur.',
   500, 60),
  ('Yoga & Stretching', 'Améliore la souplesse, réduit le stress et favorise une meilleure conscience corporelle. Complémentaire à tout régime.',
   200, 30);