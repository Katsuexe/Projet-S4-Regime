-- ============================================================
--  SCRIPT 1 : CRÉATION DE LA BASE ET DES TABLES (STRUCTURE)
--  PROJET S4 — Application Régime Alimentaire
-- ============================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS `regime_s4`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `regime_s4`;

-- 1. Utilisateurs
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

-- 2. Santé des utilisateurs
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

-- 3. Régimes
DROP TABLE IF EXISTS `regimes`;
CREATE TABLE `regimes` (
  `id`              INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  `nom`             VARCHAR(150)  NOT NULL,
  `description`     TEXT,
  `pct_viande`      DECIMAL(5,2)  NOT NULL DEFAULT 0.00,
  `pct_poisson`     DECIMAL(5,2)  NOT NULL DEFAULT 0.00,
  `pct_volaille`    DECIMAL(5,2)  NOT NULL DEFAULT 0.00,
  `delta_poids_min` DECIMAL(5,2)  DEFAULT NULL,
  `delta_poids_max` DECIMAL(5,2)  DEFAULT NULL,
  `created_at`      TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`      TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `chk_pct_total`
    CHECK (ROUND(`pct_viande` + `pct_poisson` + `pct_volaille`, 2) = 100.00)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Durées et prix par régime
DROP TABLE IF EXISTS `regime_durees`;
CREATE TABLE `regime_durees` (
  `id`          INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  `regime_id`   INT UNSIGNED  NOT NULL,
  `duree_jours` SMALLINT      NOT NULL,
  `prix`        DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_regime_duree` (`regime_id`, `duree_jours`),
  CONSTRAINT `fk_regime_durees_regime`
    FOREIGN KEY (`regime_id`) REFERENCES `regimes` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Activités sportives
DROP TABLE IF EXISTS `activites`;
CREATE TABLE `activites` (
  `id`          INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  `nom`         VARCHAR(150)  NOT NULL,
  `description` TEXT,
  `calories_h`  SMALLINT      DEFAULT NULL,
  `duree_min`   SMALLINT      DEFAULT NULL,
  `created_at`  TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`  TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Codes porte-monnaie
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

-- 7. Achats de régimes
DROP TABLE IF EXISTS `user_regimes`;
CREATE TABLE `user_regimes` (
  `id`              INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  `user_id`         INT UNSIGNED  NOT NULL,
  `regime_id`       INT UNSIGNED  NOT NULL,
  `regime_duree_id` INT UNSIGNED  NOT NULL,
  `activite_id`     INT UNSIGNED  DEFAULT NULL,
  `prix_paye`       DECIMAL(10,2) NOT NULL,
  `gold_remise`     TINYINT(1)    NOT NULL DEFAULT 0,
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

-- 8. Paramètres
DROP TABLE IF EXISTS `parametres`;
CREATE TABLE `parametres` (
  `id`        INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  `cle`       VARCHAR(100)  NOT NULL,
  `valeur`    VARCHAR(255)  NOT NULL,
  `updated_at` TIMESTAMP   NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_parametres_cle` (`cle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
