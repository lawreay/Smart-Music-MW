CREATE DATABASE IF NOT EXISTS smart_music CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE smart_music;

CREATE TABLE IF NOT EXISTS users (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(160) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin','editor','viewer') NOT NULL DEFAULT 'viewer',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS projects (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  slug VARCHAR(220) NOT NULL UNIQUE,
  summary TEXT,
  content MEDIUMTEXT,
  status ENUM('draft','published','archived') NOT NULL DEFAULT 'draft',
  featured TINYINT(1) NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  FULLTEXT KEY ft_title_summary (title, summary)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS contacts (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(160) NOT NULL,
  phone VARCHAR(40) NULL,
  message TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  handled_at TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS sessions (
  id CHAR(128) PRIMARY KEY,
  user_id BIGINT UNSIGNED NULL,
  payload TEXT,
  last_activity TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX (user_id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS songs (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  title VARCHAR(255) NOT NULL,
  artist VARCHAR(255),
  album VARCHAR(255),
  genre VARCHAR(100),
  duration INT,
  file_path VARCHAR(512) NOT NULL,
  file_size BIGINT,
  file_type VARCHAR(50),
  cover_art_path VARCHAR(512),
  description TEXT,
  is_public TINYINT(1) DEFAULT 1,
  download_count INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX idx_user_id (user_id),
  INDEX idx_is_public (is_public),
  INDEX idx_created_at (created_at)
) ENGINE=InnoDB;

CREATE INDEX idx_projects_status ON projects (status);
CREATE INDEX idx_projects_featured ON projects (featured);
CREATE INDEX idx_projects_updated_at ON projects (updated_at);
