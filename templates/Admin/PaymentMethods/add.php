<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PaymentMethod $paymentMethod
 * @var array $providers
 * @var array $paymentTypes
 */

$this->assign('title', 'Adicionar Método de Pagamento');
?>

<style>
    .add-container {
        max-width: 800px;
        margin: 0 auto;
    }
    
    .add-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    
    .add-card__header {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        padding: 2rem;
        color: white;
        text-align: center;
    }
    
    .add-card__header h1 {
        margin: 0 0 0.5rem 0;
        font-size: 1.5rem;
    }
    
    .add-card__header p {
        margin: 0;
        opacity: 0.8;
        font-size: 0.9375rem;
    }
    
    .add-card__body {
        padding: 2rem;
    }
    
    .provider-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .provider-option {
        position: relative;
        cursor: pointer;
    }
    
    .provider-option input {
        position: absolute;
        opacity: 0;
    }
    
    .provider-option__card {
        padding: 1.5rem;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        text-align: center;
        transition: all 0.2s;
    }
    
    .provider-option input:checked + .provider-option__card {
        border-color: #6366f1;
        background: #eef2ff;
    }
    
    .provider-option__card:hover {
        border-color: #a5b4fc;
    }
    
    .provider-option__icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 1rem;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
    }
    
    .provider-option__icon.pagarme { background: #00d4aa; }
    .provider-option__icon.pagseguro { background: #00a650; }
    .provider-option__icon.stripe { background: #635bff; }
    .provider-option__icon.pix_manual { background: #32bcad; }
    .provider-option__icon.cash { background: #fbbf24; }
    
    .provider-option__name {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    
    .provider-option__desc {
        font-size: 0.75rem;
        color: #64748b;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-group label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 0.5rem;
    }
    
    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 0.9375rem;
        transition: all 0.2s;
    }
    
    .form-control:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }
    
    .btn {
        padding: 0.875rem 2rem;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
        cursor: pointer;
        border: none;
    }
    
    .btn-primary {
        background: #6366f1;
        color: white;
    }
    
    .btn-primary:hover {
        background: #4f46e5;
    }
    
    .btn-outline {
        background: white;
        color: #475569;
        border: 1px solid #e2e8f0;
    }
    
    .btn-outline:hover {
        background: #f8fafc;
    }
    
    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        padding-top: 1.5rem;
        border-top: 1px solid #e5e7eb;
    }
    
    .section-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 1rem;
    }
</style>

<div class="add-container">
    <div class="add-card">
        <div class="add-card__header">
            <h1>➕ Adicionar Método de Pagamento</h1>
            <p>Selecione um gateway e configure as credenciais</p>
        </div>
        
        <div class="add-card__body">
            <?= $this->Form->create($paymentMethod) ?>
            
            <div class="section-title">Selecione o Gateway</div>
            
            <div class="provider-grid">
                <?php foreach ($providers as $key => $name): ?>
                <label class="provider-option">
                    <input type="radio" name="provider" value="<?= $key ?>" <?= $key === 'pagarme' ? 'checked' : '' ?>>
                    <div class="provider-option__card">
                        <div class="provider-option__icon <?= $key ?>">
                            <?php
                            echo match ($key) {
                                'pagarme' => '💎',
                                'pagseguro' => '🛡️',
                                'stripe' => '⚡',
                                'pix_manual' => '📱',
                                'cash' => '💵',
                                default => '💳',
                            };
                            ?>
                        </div>
                        <div class="provider-option__name"><?= h($name) ?></div>
                        <div class="provider-option__desc">
                            <?php
                            echo match ($key) {
                                'pagarme' => 'Cartão, PIX, Boleto',
                                'pagseguro' => 'Cartão, PIX, Boleto',
                                'stripe' => 'Cartão Internacional',
                                'pix_manual' => 'PIX com QR Code manual',
                                'cash' => 'Pagamento na entrega',
                                default => '',
                            };
                            ?>
                        </div>
                    </div>
                </label>
                <?php endforeach; ?>
            </div>
            
            <div class="form-group">
                <label>Nome de Exibição</label>
                <?= $this->Form->control('name', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Ex: Cartão de Crédito (Pagar.me)',
                    'required' => true
                ]) ?>
            </div>
            
            <div class="form-group">
                <label>Ambiente Inicial</label>
                <?= $this->Form->control('environment', [
                    'label' => false,
                    'class' => 'form-control',
                    'type' => 'select',
                    'options' => [
                        'sandbox' => '🧪 Sandbox (Recomendado para iniciar)',
                        'production' => '🚀 Produção'
                    ],
                    'default' => 'sandbox'
                ]) ?>
            </div>
            
            <?= $this->Form->hidden('display_order', ['value' => 10]) ?>
            <?= $this->Form->hidden('is_active', ['value' => 0]) ?>
            
            <div class="form-actions">
                <?= $this->Html->link('Cancelar', ['action' => 'index'], ['class' => 'btn btn-outline']) ?>
                <?= $this->Form->button('Continuar Configuração →', ['class' => 'btn btn-primary']) ?>
            </div>
            
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
