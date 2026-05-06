-- ============================================================
--  SCRIPT 3 : DONNÉES DISPENSABLES (TESTS)
--  (utilisateurs, santé, codes, souscriptions)
-- ============================================================

USE `regime_s4`;

-- Utilisateurs (mot de passe en clair : Azerty123!)
INSERT INTO `users` (`nom`, `prenom`, `email`, `password`, `genre`, `is_gold`, `solde`) VALUES
  ('Rakoto',    'Jean',      'jean.rakoto@mail.mg',    '$2y$12$LpQX3xCpJh8ZT1oLqJ4Y4.k8cE2TvYzUbMCXEdHdL5WRHXqVlJi6y', 'homme', 0,  50.00),
  ('Rasoa',     'Marie',     'marie.rasoa@mail.mg',    '$2y$12$LpQX3xCpJh8ZT1oLqJ4Y4.k8cE2TvYzUbMCXEdHdL5WRHXqVlJi6y', 'femme', 1,  120.00),
  ('Ramiandri', 'Paul',      'paul.ramiandri@mail.mg', '$2y$12$LpQX3xCpJh8ZT1oLqJ4Y4.k8cE2TvYzUbMCXEdHdL5WRHXqVlJi6y', 'homme', 0,  30.00),
  ('Ravelo',    'Sophie',    'sophie.ravelo@mail.mg',  '$2y$12$LpQX3xCpJh8ZT1oLqJ4Y4.k8cE2TvYzUbMCXEdHdL5WRHXqVlJi6y', 'femme', 0,  75.50),
  ('Andriana',  'Christophe','chris.andriana@mail.mg', '$2y$12$LpQX3xCpJh8ZT1oLqJ4Y4.k8cE2TvYzUbMCXEdHdL5WRHXqVlJi6y', 'homme', 1, 200.00);

-- Données de santé
INSERT INTO `user_sante` (`user_id`, `taille`, `poids`, `objectif`) VALUES
  (1, 175.00, 85.00, 'reduire'),
  (2, 162.00, 48.00, 'augmenter'),
  (3, 180.00, 95.00, 'reduire'),
  (4, 165.00, 63.00, 'ideal'),
  (5, 178.00, 72.00, 'ideal');

-- Codes de recharge (15)
INSERT INTO `codes` (`code`, `montant`, `is_used`) VALUES
  ('BIENV-2024-AAAA',  5.00, 0),
  ('BIENV-2024-BBBB',  5.00, 0),
  ('PROMO-10-CCCC',   10.00, 0),
  ('PROMO-10-DDDD',   10.00, 0),
  ('PROMO-10-EEEE',   10.00, 0),
  ('SUPER-20-FFFF',   20.00, 0),
  ('SUPER-20-GGGG',   20.00, 0),
  ('MEGA-50-HHHH',    50.00, 0),
  ('MEGA-50-IIII',    50.00, 0),
  ('GOLD-100-JJJJ',  100.00, 0),
  ('GOLD-100-KKKK',  100.00, 0),
  ('NOËL-15-LLLL',    15.00, 0),
  ('NOËL-15-MMMM',    15.00, 0),
  ('TEST-2-NNNN',      2.50, 0),
  ('TEST-2-OOOO',      2.50, 0);

-- Souscriptions d'exemple
INSERT INTO `user_regimes` (`user_id`, `regime_id`, `regime_duree_id`, `activite_id`, `prix_paye`, `gold_remise`, `date_debut`) VALUES
  (1, 3, 11, 2, 27.99, 0, '2026-04-01'),
  (2, 2,  7, 3, 33.99, 1, '2026-04-10'),
  (3, 4, 14, 4, 26.99, 0, '2026-04-15'),
  (4, 1,  2, 1, 17.99, 0, '2026-04-20'),
  (5, 5, 20, 5, 50.99, 1, '2026-05-01');
  