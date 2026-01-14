<?php
/**
 * @var \App\View\AppView $this
 * @var array $settings
 * @var bool $isOnlinePaymentEnabled
 * @var array $whatsappSettings
 */

$this->assign('title', 'Configurações da Loja');

// Helper to get setting value
$getSetting = function($key, $default = '') use ($settings) {
    return $settings[$key]['value'] ?? $default;
};
?>

<style>
    .settings-container {
        max-width: 900px;
    }
    
    .settings-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    
    .settings-header h1 {
        margin: 0;
        font-size: 1.5rem;
    }
    
    .payment-toggle-card {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        border-radius: 16px;
        padding: 2rem;
        color: white;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 2rem;
    }
    
    .payment-toggle-card__info h2 {
        margin: 0 0 0.5rem 0;
        font-size: 1.25rem;
    }
    
    .payment-toggle-card__info p {
        margin: 0;
        opacity: 0.8;
        font-size: 0.9375rem;
    }
    
    .payment-toggle-card__status {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .status-indicator {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-weight: 600;
        font-size: 0.875rem;
    }
    
    .status-indicator.enabled {
        background: #22c55e;
        color: white;
    }
    
    .status-indicator.disabled {
        background: #ef4444;
        color: white;
    }
    
    .status-indicator .dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: currentColor;
        animation: pulse-dot 2s ease-in-out infinite;
    }
    
    @keyframes pulse-dot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(1.2); }
    }
    
    .toggle-btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-size: 0.9375rem;
        font-weight: 600;
        cursor: pointer;
        border: none;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .toggle-btn.enable {
        background: #22c55e;
        color: white;
    }
    
    .toggle-btn.enable:hover {
        background: #16a34a;
    }
    
    .toggle-btn.disable {
        background: rgba(255,255,255,0.2);
        color: white;
        border: 1px solid rgba(255,255,255,0.3);
    }
    
    .toggle-btn.disable:hover {
        background: rgba(255,255,255,0.3);
    }
    
    .settings-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    
    .settings-card__header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .settings-card__header h3 {
        margin: 0;
        font-size: 1rem;
        font-weight: 600;
    }
    
    .settings-card__header .icon {
        font-size: 1.25rem;
    }
    
    .settings-card__body {
        padding: 1.5rem;
    }
    
    .form-group {
        margin-bottom: 1.25rem;
    }
    
    .form-group:last-child {
        margin-bottom: 0;
    }
    
    .form-group label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 0.5rem;
    }
    
    .form-group label small {
        font-weight: 400;
        color: #9ca3af;
        display: block;
        margin-top: 0.25rem;
    }
    
    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 0.9375rem;
        transition: all 0.2s;
        font-family: inherit;
    }
    
    .form-control:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }
    
    textarea.form-control {
        min-height: 100px;
        resize: vertical;
    }
    
    .form-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
    
    @media (max-width: 640px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }
    
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-size: 0.9375rem;
        font-weight: 500;
        cursor: pointer;
        border: none;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-primary {
        background: #1a1a2e;
        color: white;
    }
    
    .btn-primary:hover {
        background: #2d2d4a;
    }
    
    .info-box {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
    }
    
    .info-box p {
        margin: 0;
        font-size: 0.875rem;
        color: #1e40af;
    }
    
    .info-box strong {
        display: block;
        margin-bottom: 0.25rem;
    }
    
    .whatsapp-preview {
        background: #dcf8c6;
        border-radius: 12px;
        padding: 1rem;
        margin-top: 1rem;
        font-size: 0.875rem;
        line-height: 1.6;
        position: relative;
    }
    
    .whatsapp-preview::before {
        content: '📱 Prévia da mensagem';
        display: block;
        font-size: 0.75rem;
        color: #128c7e;
        font-weight: 600;
        margin-bottom: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .whatsapp-preview .header {
        color: #075e54;
        font-weight: 500;
    }
    
    .whatsapp-preview .items {
        margin: 0.75rem 0;
        padding-left: 1rem;
        border-left: 2px solid #25d366;
        color: #333;
    }
    
    .whatsapp-preview .footer {
        color: #075e54;
        font-style: italic;
    }
    
    .mode-info {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }
    
    .mode-info.online {
        background: #dcfce7;
        border: 1px solid #86efac;
    }
    
    .mode-info.whatsapp {
        background: #d1fae5;
        border: 1px solid #6ee7b7;
    }
    
    .mode-info .icon {
        font-size: 2rem;
        line-height: 1;
    }
    
    .mode-info .content h4 {
        margin: 0 0 0.25rem 0;
        font-size: 0.9375rem;
    }
    
    .mode-info .content p {
        margin: 0;
        font-size: 0.8125rem;
        color: #374151;
    }
</style>

<div class="settings-container">
    <div class="settings-header">
        <h1>⚙️ Configurações da Loja</h1>
    </div>
    
    <!-- Payment Toggle Card -->
    <div class="payment-toggle-card">
        <div class="payment-toggle-card__info">
            <h2>💳 Modo de Pagamento</h2>
            <p>
                <?php if ($isOnlinePaymentEnabled): ?>
                    Pagamento online está <strong>ATIVO</strong>. Clientes podem pagar diretamente no site.
                <?php else: ?>
                    Pagamento online está <strong>DESATIVADO</strong>. Pedidos serão enviados via WhatsApp.
                <?php endif; ?>
            </p>
        </div>
        <div class="payment-toggle-card__status">
            <span class="status-indicator <?= $isOnlinePaymentEnabled ? 'enabled' : 'disabled' ?>">
                <span class="dot"></span>
                <?= $isOnlinePaymentEnabled ? 'Online Ativo' : 'WhatsApp Ativo' ?>
            </span>
            
            <?= $this->Form->postLink(
                $isOnlinePaymentEnabled ? '🔴 Desativar Online' : '🟢 Ativar Online',
                ['action' => 'togglePayment'],
                [
                    'class' => 'toggle-btn ' . ($isOnlinePaymentEnabled ? 'disable' : 'enable'),
                    'confirm' => $isOnlinePaymentEnabled 
                        ? 'Desativar pagamento online? Os pedidos serão enviados via WhatsApp.'
                        : 'Ativar pagamento online? Certifique-se de ter configurado os gateways de pagamento.'
                ]
            ) ?>
        </div>
    </div>
    
    <!-- Current Mode Info -->
    <?php if ($isOnlinePaymentEnabled): ?>
    <div class="mode-info online">
        <span class="icon">💳</span>
        <div class="content">
            <h4>Modo: Pagamento Online</h4>
            <p>Os clientes podem adicionar produtos ao carrinho e finalizar o pagamento diretamente no site usando cartão, PIX ou boleto.</p>
        </div>
    </div>
    <?php else: ?>
    <div class="mode-info whatsapp">
        <span class="icon">📱</span>
        <div class="content">
            <h4>Modo: Pedido via WhatsApp</h4>
            <p>Os clientes selecionam os produtos e enviam o pedido via WhatsApp para finalização manual.</p>
        </div>
    </div>
    <?php endif; ?>
    
    <?= $this->Form->create(null, ['type' => 'post']) ?>
    
    <!-- WhatsApp Settings -->
    <div class="settings-card">
        <div class="settings-card__header">
            <span class="icon">📱</span>
            <h3>Configurações do WhatsApp</h3>
        </div>
        <div class="settings-card__body">
            <div class="info-box">
                <p>
                    <strong>ℹ️ Quando o pagamento online estiver desativado:</strong>
                    O botão "Finalizar Pedido" enviará automaticamente a lista de produtos selecionados para o WhatsApp configurado.
                </p>
            </div>
            
            <div class="form-group">
                <label>
                    Número do WhatsApp
                    <small>Formato: código do país + DDD + número (ex: 5511999999999)</small>
                </label>
                <input type="text" 
                       name="whatsapp_number" 
                       class="form-control" 
                       value="<?= h($getSetting('whatsapp_number', '5511999999999')) ?>"
                       placeholder="5511999999999">
            </div>
            
            <div class="form-group">
                <label>
                    Mensagem de Abertura
                    <small>Texto que aparece no início do pedido</small>
                </label>
                <textarea name="whatsapp_message_header" 
                          class="form-control"
                          placeholder="Olá! Gostaria de fazer um pedido:"><?= h($getSetting('whatsapp_message_header', 'Olá! Gostaria de fazer um pedido:')) ?></textarea>
            </div>
            
            <div class="form-group">
                <label>
                    Mensagem de Fechamento
                    <small>Texto que aparece no final do pedido</small>
                </label>
                <textarea name="whatsapp_message_footer" 
                          class="form-control"
                          placeholder="Aguardo confirmação. Obrigado!"><?= h($getSetting('whatsapp_message_footer', 'Aguardo confirmação. Obrigado!')) ?></textarea>
            </div>
            
            <!-- WhatsApp Preview -->
            <div class="whatsapp-preview">
                <div class="header" id="preview-header"><?= h($getSetting('whatsapp_message_header', 'Olá! Gostaria de fazer um pedido:')) ?></div>
                <div class="items">
                    📦 2x Lord Lion Imperial IPA - R$ 59,80<br>
                    📦 1x Golden Pride Pilsen - R$ 18,90<br>
                    ─────────────<br>
                    💰 <strong>Total: R$ 78,70</strong>
                </div>
                <div class="footer" id="preview-footer"><?= h($getSetting('whatsapp_message_footer', 'Aguardo confirmação. Obrigado!')) ?></div>
            </div>
        </div>
    </div>
    
    <!-- Store Settings -->
    <div class="settings-card">
        <div class="settings-card__header">
            <span class="icon">🏪</span>
            <h3>Configurações da Loja</h3>
        </div>
        <div class="settings-card__body">
            <div class="form-group">
                <label>Nome da Loja</label>
                <input type="text" 
                       name="store_name" 
                       class="form-control" 
                       value="<?= h($getSetting('store_name', 'Lord Lion Cervejaria')) ?>">
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Valor Mínimo do Pedido (R$)</label>
                    <input type="number" 
                           name="minimum_order_amount" 
                           class="form-control" 
                           step="0.01"
                           min="0"
                           value="<?= h($getSetting('minimum_order_amount', '20.00')) ?>">
                </div>
                
                <div class="form-group">
                    <label>Taxa de Entrega (R$)</label>
                    <input type="number" 
                           name="delivery_fee" 
                           class="form-control" 
                           step="0.01"
                           min="0"
                           value="<?= h($getSetting('delivery_fee', '5.00')) ?>">
                </div>
            </div>
        </div>
    </div>
    
    <!-- Submit -->
    <button type="submit" class="btn btn-primary">
        💾 Salvar Configurações
    </button>
    
    <?= $this->Form->end() ?>
</div>

<script>
// Live preview update
document.querySelector('textarea[name="whatsapp_message_header"]').addEventListener('input', function() {
    document.getElementById('preview-header').textContent = this.value || 'Olá! Gostaria de fazer um pedido:';
});

document.querySelector('textarea[name="whatsapp_message_footer"]').addEventListener('input', function() {
    document.getElementById('preview-footer').textContent = this.value || 'Aguardo confirmação. Obrigado!';
});
</script>
