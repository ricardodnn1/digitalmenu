-- ============================================
-- CUSTOMERS SCHEMA
-- User registration for online payments
-- ============================================

CREATE TABLE IF NOT EXISTS `customers` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(150) NOT NULL,
    `email` VARCHAR(150) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `phone` VARCHAR(20) NULL,
    `cpf` VARCHAR(14) NULL,
    
    -- Address fields
    `address_street` VARCHAR(255) NULL,
    `address_number` VARCHAR(20) NULL,
    `address_complement` VARCHAR(100) NULL,
    `address_neighborhood` VARCHAR(100) NULL,
    `address_city` VARCHAR(100) NULL,
    `address_state` VARCHAR(2) NULL,
    `address_zipcode` VARCHAR(10) NULL,
    
    -- Status and metadata
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `email_verified` TINYINT(1) NOT NULL DEFAULT 0,
    `last_login` DATETIME NULL,
    `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `modified` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_email` (`email`),
    KEY `idx_phone` (`phone`),
    KEY `idx_cpf` (`cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Customer addresses (for multiple delivery addresses)
CREATE TABLE IF NOT EXISTS `customer_addresses` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `customer_id` INT UNSIGNED NOT NULL,
    `label` VARCHAR(50) NOT NULL DEFAULT 'Casa',
    `street` VARCHAR(255) NOT NULL,
    `number` VARCHAR(20) NOT NULL,
    `complement` VARCHAR(100) NULL,
    `neighborhood` VARCHAR(100) NOT NULL,
    `city` VARCHAR(100) NOT NULL,
    `state` VARCHAR(2) NOT NULL,
    `zipcode` VARCHAR(10) NOT NULL,
    `is_default` TINYINT(1) NOT NULL DEFAULT 0,
    `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `modified` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    PRIMARY KEY (`id`),
    KEY `fk_customer_addresses_customer` (`customer_id`),
    CONSTRAINT `fk_customer_addresses_customer` 
        FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) 
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
