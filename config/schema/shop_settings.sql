-- ============================================
-- SHOP SETTINGS SCHEMA
-- Configuration for shop behavior
-- ============================================

CREATE TABLE IF NOT EXISTS `shop_settings` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `setting_key` VARCHAR(100) NOT NULL,
    `setting_value` TEXT NULL,
    `setting_type` ENUM('string', 'boolean', 'integer', 'json') NOT NULL DEFAULT 'string',
    `description` VARCHAR(255) NULL,
    `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `modified` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default settings
INSERT INTO `shop_settings` (`setting_key`, `setting_value`, `setting_type`, `description`) VALUES
('online_payment_enabled', '0', 'boolean', 'Habilita pagamento online no site'),
('whatsapp_number', '5511999999999', 'string', 'Número do WhatsApp para pedidos (com código do país)'),
('whatsapp_message_header', 'Olá! Gostaria de fazer um pedido:', 'string', 'Mensagem de abertura do pedido via WhatsApp'),
('whatsapp_message_footer', 'Aguardo confirmação. Obrigado!', 'string', 'Mensagem de fechamento do pedido via WhatsApp'),
('minimum_order_amount', '20.00', 'string', 'Valor mínimo do pedido'),
('delivery_fee', '5.00', 'string', 'Taxa de entrega padrão'),
('store_name', 'Lord Lion Cervejaria', 'string', 'Nome da loja')
ON DUPLICATE KEY UPDATE `setting_key` = VALUES(`setting_key`);
