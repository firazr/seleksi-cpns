-- Schema generated from project migrations
-- Database: seleksi_cpns
CREATE DATABASE IF NOT EXISTS `seleksi_cpns` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `seleksi_cpns`;

-- users
CREATE TABLE `users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `remember_token` VARCHAR(100) NULL DEFAULT NULL,
  `role` ENUM('admin','peserta') NOT NULL DEFAULT 'peserta',
  `nik` VARCHAR(16) NULL DEFAULT NULL,
  `domisili` VARCHAR(255) NULL DEFAULT NULL,
  `ttl` VARCHAR(255) NULL DEFAULT NULL,
  `photo_path` VARCHAR(255) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_nik_unique` (`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- password_reset_tokens
CREATE TABLE `password_reset_tokens` (
  `email` VARCHAR(255) NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- sessions (custom session table from migrations)
CREATE TABLE `sessions` (
  `id` VARCHAR(255) NOT NULL,
  `user_id` BIGINT UNSIGNED NULL DEFAULT NULL,
  `ip_address` VARCHAR(45) NULL DEFAULT NULL,
  `user_agent` TEXT NULL,
  `payload` LONGTEXT NOT NULL,
  `last_activity` INT NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- news
CREATE TABLE `news` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `category` ENUM('tahapan','tata_cara','pengumuman') NOT NULL,
  `content` TEXT NOT NULL,
  `domisili` VARCHAR(255) NULL DEFAULT NULL,
  `image_path` VARCHAR(255) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- questions
CREATE TABLE `questions` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `category` ENUM('TWK','TIU','TKP') NOT NULL,
  `question_text` TEXT NOT NULL,
  `option_a` VARCHAR(255) NOT NULL,
  `option_b` VARCHAR(255) NOT NULL,
  `option_c` VARCHAR(255) NOT NULL,
  `option_d` VARCHAR(255) NOT NULL,
  `correct_option` ENUM('a','b','c','d') NOT NULL,
  `image_path` VARCHAR(255) NULL DEFAULT NULL,
  `is_math` TINYINT(1) NOT NULL DEFAULT 0,
  `math_latex` TEXT NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- test_sessions
CREATE TABLE `test_sessions` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `domisili_penempatan` VARCHAR(255) NOT NULL,
  `category` VARCHAR(255) NOT NULL,
  `started_at` TIMESTAMP NOT NULL,
  `finished_at` TIMESTAMP NULL DEFAULT NULL,
  `score` INT NULL DEFAULT NULL,
  `score_twk` DECIMAL(5,2) NULL DEFAULT NULL,
  `score_tiu` DECIMAL(5,2) NULL DEFAULT NULL,
  `score_tkp` DECIMAL(5,2) NULL DEFAULT NULL,
  `answers` JSON NULL DEFAULT NULL,
  `shuffled_questions` LONGTEXT NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `test_sessions_user_id_index` (`user_id`),
  CONSTRAINT `test_sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- End of schema
