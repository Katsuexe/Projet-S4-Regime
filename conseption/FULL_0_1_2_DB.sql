-- Active: 1776233997297@@127.0.0.1@3306@regime_s4
-- =============================================================================
--  PROJET S4 — Application Régime Alimentaire
--  SCRIPT UNIQUE COMPLET : STRUCTURE + DONNÉES (essentielles + démo)
--  Base : MySQL 8+ / utf8mb4
-- =============================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- -----------------------------------------------------------------------------
-- PARTIE 1 : CRÉATION DE LA BASE ET DES TABLES
-- -----------------------------------------------------------------------------

CREATE DATABASE IF NOT EXISTS `regime_s4`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `regime_s4`;

-- 1. users
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id`         INT UNSIGNED     NOT NULL AUTO_INCREMENT,
  `nom`        VARCHAR(100)     NOT NULL,
  `prenom`     VARCHAR(100)     NOT NULL,
  `email`      VARCHAR(150)     NOT NULL,
  `password`   VARCHAR(255)     NOT NULL,
  `role`       ENUM('sportif','admin','coach') NOT NULL DEFAULT 'sportif',
  `genre`      ENUM('homme','femme') NOT NULL,
  `is_gold`    TINYINT(1)       NOT NULL DEFAULT 0,
  `solde`      DECIMAL(10,2)    NOT NULL DEFAULT 0.00,
  `created_at` TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_users_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. user_sante
DROP TABLE IF EXISTS `user_sante`;
CREATE TABLE `user_sante` (
  `id`        INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  `user_id`   INT UNSIGNED  NOT NULL,
  `taille`    DECIMAL(5,2)  NOT NULL COMMENT 'en cm',
  `poids`     DECIMAL(5,2)  NOT NULL COMMENT 'en kg',
  `objectif`  ENUM('augmenter','reduire','ideal') NOT NULL,
  `updated_at` TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_user_sante_user` (`user_id`),
  CONSTRAINT `fk_user_sante_user`
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. regimes
DROP TABLE IF EXISTS `regimes`;
CREATE TABLE `regimes` (
  `id`              INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  `nom`             VARCHAR(150)  NOT NULL,
  `description`     TEXT,
  `pct_viande`      DECIMAL(5,2)  NOT NULL DEFAULT 0.00 COMMENT '% viande',
  `pct_poisson`     DECIMAL(5,2)  NOT NULL DEFAULT 0.00 COMMENT '% poisson',
  `pct_volaille`    DECIMAL(5,2)  NOT NULL DEFAULT 0.00 COMMENT '% volaille',
  `delta_poids_min` DECIMAL(5,2)  DEFAULT NULL COMMENT 'variation poids min kg/mois',
  `delta_poids_max` DECIMAL(5,2)  DEFAULT NULL COMMENT 'variation poids max kg/mois',
  `created_at`      TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`      TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `chk_pct_total`
    CHECK (ROUND(`pct_viande` + `pct_poisson` + `pct_volaille`, 2) = 100.00)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. regime_durees
DROP TABLE IF EXISTS `regime_durees`;
CREATE TABLE `regime_durees` (
  `id`          INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  `regime_id`   INT UNSIGNED  NOT NULL,
  `duree_jours` SMALLINT      NOT NULL COMMENT 'durée en jours',
  `prix`        DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_regime_duree` (`regime_id`, `duree_jours`),
  CONSTRAINT `fk_regime_durees_regime`
    FOREIGN KEY (`regime_id`) REFERENCES `regimes` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. activites
DROP TABLE IF EXISTS `activites`;
CREATE TABLE `activites` (
  `id`          INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  `nom`         VARCHAR(150)  NOT NULL,
  `description` TEXT,
  `calories_h`  SMALLINT      DEFAULT NULL COMMENT 'calories brûlées par heure',
  `duree_min`   SMALLINT      DEFAULT NULL COMMENT 'durée recommandée en minutes/jour',
  `created_at`  TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`  TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. codes (portefeuille)
DROP TABLE IF EXISTS `codes`;
CREATE TABLE `codes` (
  `id`        INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  `code`      VARCHAR(50)   NOT NULL,
  `montant`   DECIMAL(10,2) NOT NULL,
  `is_used`   TINYINT(1)    NOT NULL DEFAULT 0,
  `used_by`   INT UNSIGNED  DEFAULT NULL,
  `used_at`   TIMESTAMP     NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_codes_code` (`code`),
  CONSTRAINT `fk_codes_user`
    FOREIGN KEY (`used_by`) REFERENCES `users` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. user_regimes
DROP TABLE IF EXISTS `user_regimes`;
CREATE TABLE `user_regimes` (
  `id`              INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  `user_id`         INT UNSIGNED  NOT NULL,
  `regime_id`       INT UNSIGNED  NOT NULL,
  `regime_duree_id` INT UNSIGNED  NOT NULL,
  `activite_id`     INT UNSIGNED  DEFAULT NULL,
  `prix_paye`       DECIMAL(10,2) NOT NULL,
  `gold_remise`     TINYINT(1)    NOT NULL DEFAULT 0 COMMENT '1 si remise Gold appliquée',
  `date_debut`      DATE          DEFAULT NULL,
  `created_at`      TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_ur_user`
    FOREIGN KEY (`user_id`)         REFERENCES `users`         (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_ur_regime`
    FOREIGN KEY (`regime_id`)       REFERENCES `regimes`       (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_ur_duree`
    FOREIGN KEY (`regime_duree_id`) REFERENCES `regime_durees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_ur_activite`
    FOREIGN KEY (`activite_id`)     REFERENCES `activites`     (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. parametres
DROP TABLE IF EXISTS `parametres`;
CREATE TABLE `parametres` (
  `id`        INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  `cle`       VARCHAR(100)  NOT NULL,
  `valeur`    VARCHAR(255)  NOT NULL,
  `updated_at` TIMESTAMP   NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_parametres_cle` (`cle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- PARTIE 2 : DONNÉES INDISPENSABLES (nécessaires au fonctionnement)
-- -----------------------------------------------------------------------------

-- Paramètres de configuration
INSERT INTO `parametres` (`cle`, `valeur`) VALUES
  ('prix_gold',       '29.99'),
  ('remise_gold_pct', '15'),
  ('imc_ideal_min',   '18.5'),
  ('imc_ideal_max',   '24.9'),
  ('imc_surpoids',    '25.0'),
  ('imc_obesite',     '30.0');

-- Régimes
INSERT INTO `regimes` (`id`, `nom`, `description`, `pct_viande`, `pct_poisson`, `pct_volaille`, `delta_poids_min`, `delta_poids_max`) VALUES
(1, 'Méditerranéen',   'Inspiré des pays du bassin méditerranéen, riche en poisson, légumes et huile d''olive. Idéal pour atteindre un IMC équilibré.', 20.00, 40.00, 40.00, -0.50, 0.20),
(2, 'Hyperprotéiné',   'Régime riche en protéines animales favorisant la prise de masse musculaire et l''augmentation du poids corporel.', 50.00, 20.00, 30.00, 0.30, 1.00),
(3, 'Hypocalorique',   'Régime à faible apport calorique basé sur la volaille maigre et le poisson pour une perte de poids progressive.', 15.00, 35.00, 50.00, -1.50, -0.30),
(4, 'Cétogène',        'Très faible en glucides, très riche en protéines et lipides. Favorise une perte de poids rapide par cétose.', 60.00, 10.00, 30.00, -2.00, -0.50),
(5, 'Flexitarien marin','Priorité au poisson et à la volaille, viande réduite au minimum. Équilibré et durable pour maintenir l''IMC idéal.', 5.00, 55.00, 40.00, -0.80, 0.10);

-- Prix par durée pour chaque régime
INSERT INTO `regime_durees` (`regime_id`, `duree_jours`, `prix`) VALUES
  (1,  7,   9.99), (1, 14,  17.99), (1, 30,  29.99), (1, 60,  49.99),
  (2,  7,  12.99), (2, 14,  22.99), (2, 30,  39.99), (2, 60,  69.99),
  (3,  7,   8.99), (3, 14,  15.99), (3, 30,  27.99), (3, 60,  44.99),
  (4,  7,  14.99), (4, 14,  26.99), (4, 30,  44.99), (4, 60,  79.99),
  (5,  7,  10.99), (5, 14,  19.99), (5, 30,  34.99), (5, 60,  59.99);

-- Activités sportives
INSERT INTO `activites` (`id`, `nom`, `description`, `calories_h`, `duree_min`) VALUES
(1, 'Marche rapide',    'Activité accessible à tous, idéale pour commencer. Améliore le système cardiovasculaire et favorise la perte de poids progressive.', 300, 45),
(2, 'Natation',         'Sport complet sollicitant tous les groupes musculaires. Très efficace pour brûler des calories sans impact articulaire.', 550, 45),
(3, 'Musculation',      'Entraînement en résistance pour développer la masse musculaire. Recommandé en complément d''un régime hyperprotéiné.', 400, 60),
(4, 'Vélo / Cyclisme',  'Activité cardio d''endurance. Adaptée à tous les niveaux pour entretenir la forme et perdre du poids en douceur.', 500, 60),
(5, 'Yoga & Stretching','Améliore la souplesse, réduit le stress et favorise une meilleure conscience corporelle. Complémentaire à tout régime.', 200, 30);

-- -----------------------------------------------------------------------------
-- PARTIE 3 : DONNÉES DE DÉMONSTRATION (tests)

-- -----------------------------------------------------------------------------

INSERT INTO `users` (`id`, `nom`, `prenom`, `email`, `password`, `role`, `genre`, `is_gold`, `solde`) VALUES
(1, 'Rakoto',    'Jean',       'jean.rakoto@mail.mg',    '$2y$10$Fp1WCzC/ksEBRnd8tMv3JO7e/28g8tkSvmDZ6MunlVKEmukwE44Oa', 'sportif', 'homme', 0,  50.00),
(2, 'Rasoa',     'Marie',      'marie.rasoa@mail.mg',    '$2y$10$gJ3jd9DWTSNWgCL0WRlc0untwFQum15L0X52LHOPWT3rdNxVKVBL2', 'sportif', 'femme', 1, 120.00),
(3, 'Ramiandri', 'Paul',       'paul.ramiandri@mail.mg', '$2y$10$McaBMvrrrLg2OeHc8tKfP.Ks9hPJ8/CBRUzSA5e/bOmSq8RAQBi5u', 'sportif', 'homme', 0,  30.00),
(4, 'Ravelo',    'Sophie',     'sophie.ravelo@mail.mg',  '$2y$10$/yVfbDodJCCL/h25QaPijeJU9kqoWy5U.AWnC/k6itsfFyUiPXPV.', 'sportif', 'femme', 0,  75.50),
(5, 'Andriana',  'Christophe', 'chris.andriana@mail.mg', '$2y$10$zRp8cyiXBpDWBpaJdTKhCu2DEl68jnU4itGARzhPcYthXmjboJOO6', 'sportif', 'homme', 1, 200.00),
(6, 'Admin',     'Systeme',    'admin@regime.local',     '$2y$10$QVmIOwLxQUPZkaiRKzYO1ehBLESWORvQ7lARNKhY0vdfwHWmTQ33q', 'admin',   'homme', 0,   0.00),
(7, 'Coach',     'Principal',  'coach@regime.local',     '$2y$10$u.HcnV5DjSacjzLUha.Oo.PjkfOu8KHc5lPPRCjoqYdqPjcwimgsy', 'coach',   'femme', 0,   0.00);

INSERT INTO `user_sante` (`user_id`, `taille`, `poids`, `objectif`) VALUES
(1, 175.00, 85.00, 'reduire'),
(2, 162.00, 48.00, 'augmenter'),
(3, 180.00, 95.00, 'reduire'),
(4, 165.00, 63.00, 'ideal'),
(5, 178.00, 72.00, 'ideal');

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

INSERT INTO `user_regimes` (`user_id`, `regime_id`, `regime_duree_id`, `activite_id`, `prix_paye`, `gold_remise`, `date_debut`) VALUES
(1, 3, 11, 2, 27.99, 0, '2026-04-01'),
(2, 2,  7, 3, 33.99, 1, '2026-04-10'),
(3, 4, 14, 4, 26.99, 0, '2026-04-15'),
(4, 1,  2, 1, 17.99, 0, '2026-04-20'),
(5, 5, 20, 5, 50.99, 1, '2026-05-01');

-- -----------------------------------------------------------------------------
-- VÉRIFICATIONS (optionnelles) : remise à zéro auto-incréments si nécessaire
-- -----------------------------------------------------------------------------
-- ALTER TABLE `regimes`       AUTO_INCREMENT = 6;
-- ALTER TABLE `activites`    AUTO_INCREMENT = 6;
-- ALTER TABLE `users`        AUTO_INCREMENT = 8;

SET FOREIGN_KEY_CHECKS = 1;
-- =============================================================================
-- FIN DU SCRIPT UNIQUE
-- =============================================================================
