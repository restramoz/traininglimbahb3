-- Schema MySQL/MariaDB hasil ekspor SQLite.
-- Import ke database kosong terlebih dahulu.
SET FOREIGN_KEY_CHECKS=0;

CREATE TABLE `article_generation_jobs` (
  `id` VARCHAR(255),
  `user_id` BIGINT UNSIGNED DEFAULT NULL,
  `status` VARCHAR(255) NOT NULL DEFAULT 'queued',
  `result` LONGTEXT DEFAULT NULL,
  `error` LONGTEXT DEFAULT NULL,
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `articles` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `excerpt` TEXT DEFAULT NULL,
  `content` LONGTEXT NOT NULL,
  `featured_image` VARCHAR(255) DEFAULT NULL,
  `image_brief` JSON DEFAULT NULL,
  `seo_title` VARCHAR(255) DEFAULT NULL,
  `meta_description` TEXT DEFAULT NULL,
  `target_city_slug` VARCHAR(255) DEFAULT NULL,
  `target_district_slug` VARCHAR(255) DEFAULT NULL,
  `faqs` JSON DEFAULT NULL,
  `status` VARCHAR(20) NOT NULL DEFAULT 'draft',
  `published_at` DATETIME DEFAULT NULL,
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_articles_status` ON `articles` (`status`);

CREATE INDEX `idx_articles_target_district_slug` ON `articles` (`target_district_slug`);

CREATE INDEX `idx_articles_target_city_slug` ON `articles` (`target_city_slug`);

CREATE UNIQUE INDEX `uq_articles_slug` ON `articles` (`slug`);


CREATE TABLE `cache` (
  `key` VARCHAR(255),
  `value` LONGTEXT NOT NULL,
  `expiration` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_cache_expiration` ON `cache` (`expiration`);


CREATE TABLE `cache_locks` (
  `key` VARCHAR(255),
  `owner` VARCHAR(255) NOT NULL,
  `expiration` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_cache_locks_expiration` ON `cache_locks` (`expiration`);


CREATE TABLE `cities` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `bps_code` VARCHAR(255) NOT NULL,
  `bps_province_code` VARCHAR(255) NOT NULL,
  `province` VARCHAR(255) NOT NULL,
  `island` VARCHAR(255) NOT NULL,
  `classification` VARCHAR(255) NOT NULL,
  `is_hub` TINYINT(1) NOT NULL DEFAULT '0',
  `status` VARCHAR(255) NOT NULL DEFAULT 'active',
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_cities_bps_province_code` ON `cities` (`bps_province_code`);

CREATE UNIQUE INDEX `uq_cities_bps_code` ON `cities` (`bps_code`);

CREATE UNIQUE INDEX `uq_cities_slug` ON `cities` (`slug`);


CREATE TABLE `failed_jobs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` VARCHAR(255) NOT NULL,
  `connection` VARCHAR(255) NOT NULL,
  `queue` VARCHAR(255) NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `exception` LONGTEXT NOT NULL,
  `failed_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE UNIQUE INDEX `uq_failed_jobs_uuid` ON `failed_jobs` (`uuid`);

CREATE INDEX `idx_failed_jobs_connection_queue_failed_at` ON `failed_jobs` (`connection`, `queue`, `failed_at`);


CREATE TABLE `job_batches` (
  `id` VARCHAR(255),
  `name` VARCHAR(255) NOT NULL,
  `total_jobs` BIGINT UNSIGNED NOT NULL,
  `pending_jobs` BIGINT UNSIGNED NOT NULL,
  `failed_jobs` BIGINT UNSIGNED NOT NULL,
  `failed_job_ids` LONGTEXT NOT NULL,
  `options` LONGTEXT DEFAULT NULL,
  `cancelled_at` BIGINT UNSIGNED DEFAULT NULL,
  `created_at` BIGINT UNSIGNED NOT NULL,
  `finished_at` BIGINT UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `jobs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` VARCHAR(255) NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `attempts` BIGINT UNSIGNED NOT NULL,
  `reserved_at` BIGINT UNSIGNED DEFAULT NULL,
  `available_at` BIGINT UNSIGNED NOT NULL,
  `created_at` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_jobs_queue` ON `jobs` (`queue`);


CREATE TABLE `kecamatans` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `city_id` BIGINT UNSIGNED NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `bps_code` VARCHAR(255) NOT NULL,
  `status` VARCHAR(255) NOT NULL DEFAULT 'active',
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_kecamatans_bps_code` ON `kecamatans` (`bps_code`);

CREATE UNIQUE INDEX `uq_kecamatans_city_id_bps_code` ON `kecamatans` (`city_id`, `bps_code`);


CREATE TABLE `migrations` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` VARCHAR(255) NOT NULL,
  `batch` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `password_reset_tokens` (
  `email` VARCHAR(255),
  `token` VARCHAR(255) NOT NULL,
  `created_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `sessions` (
  `id` VARCHAR(255),
  `user_id` BIGINT UNSIGNED DEFAULT NULL,
  `ip_address` VARCHAR(255) DEFAULT NULL,
  `user_agent` LONGTEXT DEFAULT NULL,
  `payload` LONGTEXT NOT NULL,
  `last_activity` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_sessions_last_activity` ON `sessions` (`last_activity`);

CREATE INDEX `idx_sessions_user_id` ON `sessions` (`user_id`);


CREATE TABLE `users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `email_verified_at` DATETIME DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `remember_token` VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  `is_admin` BIGINT NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_users_is_admin` ON `users` (`is_admin`);

CREATE UNIQUE INDEX `uq_users_email` ON `users` (`email`);


SET FOREIGN_KEY_CHECKS=1;
