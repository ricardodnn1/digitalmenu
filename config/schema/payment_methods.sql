-- ============================================
-- PAYMENT METHODS SCHEMA
-- Database structure for payment gateway management
-- ============================================

-- Payment Methods Configuration Table
CREATE TABLE IF NOT EXISTS `payment_methods` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL COMMENT 'Display name',
    `provider` VARCHAR(50) NOT NULL COMMENT 'Provider: pagarme, pagseguro, stripe, pix, boleto, cash',
    `is_active` TINYINT(1) NOT NULL DEFAULT 0,
    `is_default` TINYINT(1) NOT NULL DEFAULT 0,
    `environment` ENUM('sandbox', 'production') NOT NULL DEFAULT 'sandbox',
    `api_key` TEXT NULL COMMENT 'Encrypted API Key',
    `api_secret` TEXT NULL COMMENT 'Encrypted API Secret',
    `webhook_secret` VARCHAR(255) NULL COMMENT 'Webhook validation secret',
    `webhook_url` VARCHAR(500) NULL COMMENT 'Generated webhook URL',
    `additional_config` JSON NULL COMMENT 'Provider-specific configuration',
    `supported_methods` JSON NULL COMMENT 'Credit, Debit, PIX, Boleto, etc.',
    `fee_percentage` DECIMAL(5,2) NULL DEFAULT 0.00 COMMENT 'Transaction fee %',
    `fee_fixed` DECIMAL(10,2) NULL DEFAULT 0.00 COMMENT 'Fixed fee per transaction',
    `min_amount` DECIMAL(10,2) NULL DEFAULT 0.00 COMMENT 'Minimum transaction amount',
    `max_amount` DECIMAL(10,2) NULL DEFAULT 999999.99 COMMENT 'Maximum transaction amount',
    `display_order` INT NOT NULL DEFAULT 0,
    `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `modified` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_provider_environment` (`provider`, `environment`),
    KEY `idx_is_active` (`is_active`),
    KEY `idx_display_order` (`display_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Payment Transactions Log Table
CREATE TABLE IF NOT EXISTS `payment_transactions` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `payment_method_id` INT UNSIGNED NOT NULL,
    `order_id` INT UNSIGNED NULL,
    `external_id` VARCHAR(255) NULL COMMENT 'Transaction ID from provider',
    `reference_code` VARCHAR(100) NULL COMMENT 'Internal reference code',
    `amount` DECIMAL(10,2) NOT NULL,
    `currency` VARCHAR(3) NOT NULL DEFAULT 'BRL',
    `status` ENUM('pending', 'processing', 'approved', 'declined', 'refunded', 'cancelled', 'expired') NOT NULL DEFAULT 'pending',
    `payment_type` VARCHAR(50) NULL COMMENT 'credit_card, debit_card, pix, boleto, etc.',
    `installments` TINYINT UNSIGNED NULL DEFAULT 1,
    `customer_name` VARCHAR(255) NULL,
    `customer_email` VARCHAR(255) NULL,
    `customer_document` VARCHAR(20) NULL COMMENT 'CPF/CNPJ',
    `card_last_digits` VARCHAR(4) NULL,
    `card_brand` VARCHAR(50) NULL,
    `pix_qr_code` TEXT NULL,
    `pix_qr_code_url` VARCHAR(500) NULL,
    `boleto_url` VARCHAR(500) NULL,
    `boleto_barcode` VARCHAR(100) NULL,
    `boleto_due_date` DATE NULL,
    `provider_response` JSON NULL COMMENT 'Full response from provider',
    `error_code` VARCHAR(50) NULL,
    `error_message` TEXT NULL,
    `paid_at` DATETIME NULL,
    `refunded_at` DATETIME NULL,
    `expires_at` DATETIME NULL,
    `metadata` JSON NULL,
    `ip_address` VARCHAR(45) NULL,
    `user_agent` TEXT NULL,
    `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `modified` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `fk_payment_method` (`payment_method_id`),
    KEY `idx_external_id` (`external_id`),
    KEY `idx_reference_code` (`reference_code`),
    KEY `idx_status` (`status`),
    KEY `idx_created` (`created`),
    CONSTRAINT `fk_transaction_payment_method` FOREIGN KEY (`payment_method_id`) 
        REFERENCES `payment_methods` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Webhook Logs Table
CREATE TABLE IF NOT EXISTS `webhook_logs` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `payment_method_id` INT UNSIGNED NULL,
    `provider` VARCHAR(50) NOT NULL,
    `event_type` VARCHAR(100) NOT NULL,
    `external_id` VARCHAR(255) NULL,
    `payload` JSON NOT NULL,
    `headers` JSON NULL,
    `signature` VARCHAR(500) NULL,
    `signature_valid` TINYINT(1) NULL,
    `processed` TINYINT(1) NOT NULL DEFAULT 0,
    `processed_at` DATETIME NULL,
    `error_message` TEXT NULL,
    `ip_address` VARCHAR(45) NULL,
    `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_provider` (`provider`),
    KEY `idx_event_type` (`event_type`),
    KEY `idx_external_id` (`external_id`),
    KEY `idx_processed` (`processed`),
    KEY `idx_created` (`created`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default payment methods
INSERT INTO `payment_methods` (`name`, `provider`, `is_active`, `environment`, `supported_methods`, `display_order`) VALUES
('Pagar.me', 'pagarme', 0, 'sandbox', '["credit_card", "debit_card", "pix", "boleto"]', 1),
('PagSeguro', 'pagseguro', 0, 'sandbox', '["credit_card", "debit_card", "pix", "boleto"]', 2),
('Stripe', 'stripe', 0, 'sandbox', '["credit_card", "debit_card"]', 3),
('PIX Manual', 'pix_manual', 0, 'production', '["pix"]', 4),
('Dinheiro', 'cash', 1, 'production', '["cash"]', 5)
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);
