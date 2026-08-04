-- ============================================================
-- LoanCalc - Bank Loan EMI Calculator & Loan Application Portal
-- Database: loan_calc
-- Engine: MySQL 8.0+ / MariaDB 10.4+
-- ============================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS `loan_calc` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `loan_calc`;

-- ------------------------------------------------------------
-- Table: users
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `full_name` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('user','admin') NOT NULL DEFAULT 'user',
  `address` VARCHAR(255) DEFAULT NULL,
  `dob` DATE DEFAULT NULL,
  `profile_image` VARCHAR(255) DEFAULT 'default.png',
  `reset_token` VARCHAR(255) DEFAULT NULL,
  `reset_expires` DATETIME DEFAULT NULL,
  `status` ENUM('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `uq_users_email` (`email`),
  KEY `idx_users_role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Table: admin  (separate admin registry linked to users)
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NOT NULL,
  `designation` VARCHAR(100) DEFAULT 'Loan Officer',
  `permissions` VARCHAR(255) DEFAULT 'all',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `uq_admin_user` (`user_id`),
  CONSTRAINT `fk_admin_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Table: banks
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `banks`;
CREATE TABLE `banks` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `bank_name` VARCHAR(150) NOT NULL,
  `bank_code` VARCHAR(20) NOT NULL,
  `logo` VARCHAR(255) DEFAULT NULL,
  `interest_rate_min` DECIMAL(5,2) NOT NULL,
  `interest_rate_max` DECIMAL(5,2) NOT NULL,
  `processing_fee_percent` DECIMAL(5,2) DEFAULT 1.00,
  `status` ENUM('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `uq_bank_code` (`bank_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Table: loan_types
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `loan_types`;
CREATE TABLE `loan_types` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(100) NOT NULL,
  `description` TEXT,
  `min_amount` DECIMAL(15,2) NOT NULL DEFAULT 10000,
  `max_amount` DECIMAL(15,2) NOT NULL DEFAULT 5000000,
  `min_tenure_months` INT NOT NULL DEFAULT 6,
  `max_tenure_months` INT NOT NULL DEFAULT 360,
  `base_interest_rate` DECIMAL(5,2) NOT NULL DEFAULT 10.00,
  `icon` VARCHAR(50) DEFAULT 'bi-cash-coin',
  `status` ENUM('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `uq_loan_type_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Table: loan_applications
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `loan_applications`;
CREATE TABLE `loan_applications` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `application_no` VARCHAR(30) NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  `loan_type_id` INT UNSIGNED NOT NULL,
  `bank_id` INT UNSIGNED NOT NULL,
  `loan_amount` DECIMAL(15,2) NOT NULL,
  `tenure_months` INT NOT NULL,
  `interest_rate` DECIMAL(5,2) NOT NULL,
  `monthly_income` DECIMAL(15,2) DEFAULT NULL,
  `employment_type` ENUM('salaried','self_employed','business','other') DEFAULT 'salaried',
  `purpose` VARCHAR(255) DEFAULT NULL,
  `emi_amount` DECIMAL(15,2) DEFAULT NULL,
  `total_payable` DECIMAL(15,2) DEFAULT NULL,
  `total_interest` DECIMAL(15,2) DEFAULT NULL,
  `documents` TEXT COMMENT 'JSON list of uploaded document paths',
  `current_status` ENUM('pending','under_review','approved','rejected','disbursed') NOT NULL DEFAULT 'pending',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `uq_application_no` (`application_no`),
  KEY `idx_loan_app_user` (`user_id`),
  KEY `idx_loan_app_status` (`current_status`),
  CONSTRAINT `fk_loanapp_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_loanapp_type` FOREIGN KEY (`loan_type_id`) REFERENCES `loan_types`(`id`) ON DELETE RESTRICT,
  CONSTRAINT `fk_loanapp_bank` FOREIGN KEY (`bank_id`) REFERENCES `banks`(`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Table: loan_status  (status history / audit trail)
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `loan_status`;
CREATE TABLE `loan_status` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `loan_application_id` INT UNSIGNED NOT NULL,
  `status` ENUM('pending','under_review','approved','rejected','disbursed') NOT NULL,
  `remarks` VARCHAR(255) DEFAULT NULL,
  `updated_by` INT UNSIGNED DEFAULT NULL COMMENT 'admin user id',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  KEY `idx_loanstatus_app` (`loan_application_id`),
  CONSTRAINT `fk_loanstatus_app` FOREIGN KEY (`loan_application_id`) REFERENCES `loan_applications`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_loanstatus_admin` FOREIGN KEY (`updated_by`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Table: emi_records  (amortization schedule / saved EMI calcs)
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `emi_records`;
CREATE TABLE `emi_records` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED DEFAULT NULL,
  `loan_application_id` INT UNSIGNED DEFAULT NULL,
  `principal` DECIMAL(15,2) NOT NULL,
  `interest_rate` DECIMAL(5,2) NOT NULL,
  `tenure_months` INT NOT NULL,
  `emi_amount` DECIMAL(15,2) NOT NULL,
  `total_interest` DECIMAL(15,2) NOT NULL,
  `total_payment` DECIMAL(15,2) NOT NULL,
  `schedule_json` LONGTEXT COMMENT 'JSON amortization schedule',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  KEY `idx_emi_user` (`user_id`),
  CONSTRAINT `fk_emi_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_emi_app` FOREIGN KEY (`loan_application_id`) REFERENCES `loan_applications`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Table: contact_messages
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `contact_messages`;
CREATE TABLE `contact_messages` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `subject` VARCHAR(200) DEFAULT NULL,
  `message` TEXT NOT NULL,
  `is_read` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  KEY `idx_contact_read` (`is_read`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Table: notifications
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NOT NULL,
  `title` VARCHAR(200) NOT NULL,
  `message` VARCHAR(500) NOT NULL,
  `type` ENUM('info','success','warning','danger') NOT NULL DEFAULT 'info',
  `is_read` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  KEY `idx_notif_user` (`user_id`),
  CONSTRAINT `fk_notif_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Table: email_logs
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `email_logs`;
CREATE TABLE `email_logs` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `to_email` VARCHAR(150) NOT NULL,
  `subject` VARCHAR(255) NOT NULL,
  `body` TEXT,
  `status` ENUM('sent','failed') NOT NULL DEFAULT 'sent',
  `related_type` VARCHAR(50) DEFAULT NULL COMMENT 'e.g. loan_application, registration',
  `related_id` INT UNSIGNED DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  KEY `idx_emaillog_email` (`to_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================
-- SAMPLE DATA
-- ============================================================

-- Admin + demo users (password for all demo accounts = "Password@123")
INSERT INTO `users` (`full_name`,`email`,`phone`,`password`,`role`,`address`,`status`) VALUES
('System Administrator','admin@loancalc.test','9999999999','$2y$10$92BpP2Kq1qk1WjqvV3z1EOe5b9M8v0i1ZC1nQ3s1kQnq1r6b8T1a2','admin','Head Office, Mumbai','active'),
('Rahul Sharma','rahul.sharma@example.com','9876543210','$2y$10$92BpP2Kq1qk1WjqvV3z1EOe5b9M8v0i1ZC1nQ3s1kQnq1r6b8T1a2','user','Pune, Maharashtra','active'),
('Priya Patel','priya.patel@example.com','9876500011','$2y$10$92BpP2Kq1qk1WjqvV3z1EOe5b9M8v0i1ZC1nQ3s1kQnq1r6b8T1a2','user','Ahmedabad, Gujarat','active');

INSERT INTO `admin` (`user_id`,`designation`,`permissions`) VALUES (1,'Chief Loan Officer','all');

INSERT INTO `banks` (`bank_name`,`bank_code`,`interest_rate_min`,`interest_rate_max`,`processing_fee_percent`,`status`) VALUES
('HDFC Bank','HDFC',8.50,14.00,1.00,'active'),
('ICICI Bank','ICICI',8.75,14.50,1.00,'active'),
('State Bank of India','SBI',8.40,13.50,0.75,'active'),
('Axis Bank','AXIS',8.90,15.00,1.25,'active'),
('Kotak Mahindra Bank','KOTAK',9.00,15.50,1.00,'active');

INSERT INTO `loan_types` (`name`,`slug`,`description`,`min_amount`,`max_amount`,`min_tenure_months`,`max_tenure_months`,`base_interest_rate`,`icon`) VALUES
('Home Loan','home-loan','Finance your dream home with attractive interest rates.',100000,10000000,60,360,8.50,'bi-house-door'),
('Personal Loan','personal-loan','Quick unsecured loans for personal needs.',10000,2000000,6,60,11.50,'bi-person-badge'),
('Car Loan','car-loan','Drive home your favorite car with easy EMIs.',50000,3000000,12,84,9.25,'bi-car-front'),
('Education Loan','education-loan','Fund your higher education aspirations.',50000,4000000,12,180,9.75,'bi-mortarboard'),
('Business Loan','business-loan','Grow your business with flexible financing.',100000,5000000,12,120,12.00,'bi-briefcase');

INSERT INTO `loan_applications` (`application_no`,`user_id`,`loan_type_id`,`bank_id`,`loan_amount`,`tenure_months`,`interest_rate`,`monthly_income`,`employment_type`,`purpose`,`emi_amount`,`total_payable`,`total_interest`,`current_status`) VALUES
('LC2026000001',2,2,1,500000,36,11.50,65000,'salaried','Home renovation',16487.00,593532.00,93532.00,'approved'),
('LC2026000002',3,1,3,2500000,240,8.40,90000,'salaried','Purchase of 2BHK flat',21389.00,5133360.00,2633360.00,'under_review');

INSERT INTO `loan_status` (`loan_application_id`,`status`,`remarks`,`updated_by`) VALUES
(1,'pending','Application received',NULL),
(1,'under_review','Documents verified',1),
(1,'approved','Loan approved and sanctioned',1),
(2,'pending','Application received',NULL),
(2,'under_review','Under credit assessment',1);

INSERT INTO `notifications` (`user_id`,`title`,`message`,`type`) VALUES
(2,'Loan Approved','Your personal loan application LC2026000001 has been approved.','success'),
(3,'Application Received','Your home loan application LC2026000002 is under review.','info');

INSERT INTO `contact_messages` (`name`,`email`,`phone`,`subject`,`message`) VALUES
('Amit Verma','amit.verma@example.com','9123456780','Query about home loan','I would like to know more about the home loan interest rates.');

-- ============================================================
-- END OF loan_calc.sql
-- ============================================================


SELECT id, full_name, email, role, status;

SELECT email, password;

UPDATE users
SET email = 'admin31@gmail.com'
WHERE role = 'admin';

UPDATE users
SET password = '$2y$10$jBymjQ..Bn38xIf6I9NDy..MgfY55HhhyOF2wFg1PBvlP7kK.Zf22'
WHERE role = 'admin';

SELECT email, password;

UPDATE users
SET password = '$2y$10$d7qS7kld2xpe5r7GK56vcu9CL6Ew/MO3f3jTS9B0CW7/6RMY3SyG.'
WHERE role = 'admin';
