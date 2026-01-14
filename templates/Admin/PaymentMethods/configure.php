<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PaymentMethod $paymentMethod
 * @var array $providers
 * @var array $paymentTypes
 * @var string $baseUrl
 */

$this->assign('title', 'Configurar ' . $paymentMethod->name);
?>

<style>
    .config-container {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 2rem;
        max-width: 1400px;
    }
    
    @media (max-width: 1024px) {
        .config-container {
            grid-template-columns: 1fr;
        }
    }
    
    .config-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-bottom: 1.5rem;
    }
    
    .config-card__header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .config-card__header h3 {
        margin: 0;
        font-size: 1rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .config-card__body {
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
    
    .form-control.mono {
        font-family: 'Fira Code', 'Monaco', monospace;
        font-size: 0.8125rem;
    }
    
    .form-control[readonly] {
        background: #f8fafc;
        cursor: default;
    }
    
    select.form-control {
        cursor: pointer;
    }
    
    .form-check {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        margin-bottom: 0.5rem;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .form-check:hover {
        background: #f8fafc;
    }
    
    .form-check input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }
    
    .form-check-label {
        flex: 1;
        cursor: pointer;
    }
    
    .form-check-label strong {
        display: block;
        font-size: 0.875rem;
    }
    
    .form-check-label small {
        color: #6b7280;
        font-size: 0.75rem;
    }
    
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-size: 0.9375rem;
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
        background: #1a1a2e;
        color: white;
    }
    
    .btn-primary:hover {
        background: #2d2d4a;
    }
    
    .btn-success {
        background: #22c55e;
        color: white;
    }
    
    .btn-warning {
        background: #f59e0b;
        color: white;
    }
    
    .btn-outline {
        background: white;
        color: #475569;
        border: 1px solid #e2e8f0;
    }
    
    .btn-outline:hover {
        background: #f8fafc;
    }
    
    .btn-block {
        width: 100%;
        justify-content: center;
    }
    
    .webhook-url-box {
        background: #1e293b;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
    }
    
    .webhook-url-box code {
        display: block;
        color: #22d3ee;
        font-family: 'Fira Code', 'Monaco', monospace;
        font-size: 0.75rem;
        word-break: break-all;
        line-height: 1.5;
    }
    
    .webhook-url-box__actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 0.75rem;
    }
    
    .webhook-url-box__actions button {
        padding: 0.375rem 0.75rem;
        font-size: 0.75rem;
        background: rgba(255,255,255,0.1);
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .webhook-url-box__actions button:hover {
        background: rgba(255,255,255,0.2);
    }
    
    .info-box {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
    }
    
    .info-box h4 {
        margin: 0 0 0.5rem 0;
        font-size: 0.875rem;
        color: #1e40af;
    }
    
    .info-box p, .info-box ul {
        margin: 0;
        font-size: 0.8125rem;
        color: #3b82f6;
    }
    
    .info-box ul {
        padding-left: 1.25rem;
        margin-top: 0.5rem;
    }
    
    .warning-box {
        background: #fef3c7;
        border: 1px solid #fcd34d;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
    }
    
    .warning-box p {
        margin: 0;
        font-size: 0.8125rem;
        color: #92400e;
    }
    
    .success-box {
        background: #dcfce7;
        border: 1px solid #86efac;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
    }
    
    .success-box p {
        margin: 0;
        font-size: 0.8125rem;
        color: #166534;
    }
    
    .sidebar-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    
    .sidebar-card__header {
        padding: 1rem 1.25rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .sidebar-card__header h4 {
        margin: 0;
        font-size: 1rem;
    }
    
    .sidebar-card__body {
        padding: 1.25rem;
    }
    
    .status-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .status-list li {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .status-list li:last-child {
        border-bottom: none;
    }
    
    .status-list dt {
        font-size: 0.875rem;
        color: #64748b;
    }
    
    .status-list dd {
        margin: 0;
        font-weight: 600;
    }
    
    .status-indicator {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        font-size: 0.8125rem;
    }
    
    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }
    
    .status-dot.active { background: #22c55e; }
    .status-dot.inactive { background: #ef4444; }
    .status-dot.warning { background: #f59e0b; }
    
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    
    .page-header h1 {
        margin: 0;
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .provider-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .provider-badge.pagarme { background: #00d4aa; color: white; }
    .provider-badge.pagseguro { background: #00a650; color: white; }
    .provider-badge.stripe { background: #635bff; color: white; }
    
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
    
    .help-link {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.75rem;
        color: #6366f1;
        text-decoration: none;
        margin-top: 0.5rem;
    }
    
    .help-link:hover {
        text-decoration: underline;
    }
</style>

<div class="page-header">
    <h1>
        <?= $this->Html->link('← ', ['action' => 'index']) ?>
        Configurar <?= h($paymentMethod->name) ?>
        <span class="provider-badge <?= h($paymentMethod->provider) ?>"><?= h($paymentMethod->provider) ?></span>
    </h1>
</div>

<div class="config-container">
    <div class="config-main">
        <?= $this->Form->create($paymentMethod) ?>
        
        <!-- Basic Settings -->
        <div class="config-card">
            <div class="config-card__header">
                <h3>⚙️ Configurações Básicas</h3>
            </div>
            <div class="config-card__body">
                <div class="form-row">
                    <div class="form-group">
                        <label>Nome de Exibição</label>
                        <?= $this->Form->control('name', [
                            'label' => false,
                            'class' => 'form-control',
                            'placeholder' => 'Ex: Cartão de Crédito'
                        ]) ?>
                    </div>
                    
                    <div class="form-group">
                        <label>Ambiente</label>
                        <?= $this->Form->control('environment', [
                            'label' => false,
                            'class' => 'form-control',
                            'options' => [
                                'sandbox' => '🧪 Sandbox (Testes)',
                                'production' => '🚀 Produção'
                            ]
                        ]) ?>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Ordem de Exibição</label>
                        <?= $this->Form->control('display_order', [
                            'label' => false,
                            'class' => 'form-control',
                            'type' => 'number',
                            'min' => 0
                        ]) ?>
                    </div>
                    
                    <div class="form-group">
                        <label>Status</label>
                        <?= $this->Form->control('is_active', [
                            'label' => false,
                            'class' => 'form-control',
                            'type' => 'select',
                            'options' => [
                                0 => '🔴 Inativo',
                                1 => '🟢 Ativo'
                            ]
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- API Credentials -->
        <div class="config-card">
            <div class="config-card__header">
                <h3>🔑 Credenciais da API</h3>
                <?php if ($paymentMethod->environment === 'sandbox'): ?>
                    <span class="provider-badge" style="background: #fef3c7; color: #92400e;">Modo Teste</span>
                <?php endif; ?>
            </div>
            <div class="config-card__body">
                <?php if ($paymentMethod->provider === 'pagarme'): ?>
                    <div class="info-box">
                        <h4>📘 Onde encontrar as credenciais do Pagar.me</h4>
                        <ul>
                            <li>Acesse o <a href="https://dashboard.pagar.me" target="_blank">Dashboard Pagar.me</a></li>
                            <li>Vá em Configurações → Chaves de API</li>
                            <li>Copie a <strong>Secret Key</strong> (API Key)</li>
                        </ul>
                    </div>
                <?php elseif ($paymentMethod->provider === 'pagseguro'): ?>
                    <div class="info-box">
                        <h4>📘 Onde encontrar as credenciais do PagSeguro</h4>
                        <ul>
                            <li>Acesse o <a href="https://minhaconta.pagseguro.uol.com.br" target="_blank">Minha Conta PagSeguro</a></li>
                            <li>Vá em Integrações → Gerar Token</li>
                            <li>Copie o <strong>Token</strong> gerado</li>
                        </ul>
                    </div>
                <?php elseif ($paymentMethod->provider === 'stripe'): ?>
                    <div class="info-box">
                        <h4>📘 Onde encontrar as credenciais do Stripe</h4>
                        <ul>
                            <li>Acesse o <a href="https://dashboard.stripe.com/apikeys" target="_blank">Dashboard Stripe</a></li>
                            <li>Vá em Developers → API Keys</li>
                            <li>Copie a <strong>Secret Key</strong></li>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <div class="form-group">
                    <label>
                        API Key / Token
                        <small>(Chave Secreta)</small>
                    </label>
                    <?= $this->Form->control('api_key', [
                        'label' => false,
                        'class' => 'form-control mono',
                        'type' => 'password',
                        'placeholder' => 'sk_live_...',
                        'autocomplete' => 'off'
                    ]) ?>
                </div>
                
                <?php if (in_array($paymentMethod->provider, ['pagseguro'])): ?>
                <div class="form-group">
                    <label>
                        API Secret / Email
                        <small>(Se necessário)</small>
                    </label>
                    <?= $this->Form->control('api_secret', [
                        'label' => false,
                        'class' => 'form-control mono',
                        'type' => 'password',
                        'placeholder' => 'Email da conta PagSeguro',
                        'autocomplete' => 'off'
                    ]) ?>
                </div>
                <?php endif; ?>
                
                <div style="display: flex; gap: 0.75rem; margin-top: 1rem;">
                    <?= $this->Form->postLink(
                        '🔌 Testar Conexão',
                        ['action' => 'testConnection', $paymentMethod->id],
                        ['class' => 'btn btn-success']
                    ) ?>
                </div>
            </div>
        </div>
        
        <!-- Webhook Configuration -->
        <div class="config-card">
            <div class="config-card__header">
                <h3>🔔 Configuração do Webhook</h3>
            </div>
            <div class="config-card__body">
                <p style="font-size: 0.875rem; color: #64748b; margin-bottom: 1rem;">
                    Configure a URL abaixo no painel do <?= h($providers[$paymentMethod->provider] ?? $paymentMethod->provider) ?> 
                    para receber notificações de pagamento em tempo real.
                </p>
                
                <div class="webhook-url-box">
                    <code id="webhook-url"><?= h($paymentMethod->webhook_url ?? 'URL não gerada') ?></code>
                    <div class="webhook-url-box__actions">
                        <button type="button" onclick="copyWebhookUrl()">📋 Copiar URL</button>
                        <?= $this->Form->postLink(
                            '🔄 Regenerar URL',
                            ['action' => 'regenerateWebhook', $paymentMethod->id],
                            [
                                'class' => '',
                                'style' => 'padding: 0.375rem 0.75rem; font-size: 0.75rem; background: rgba(255,255,255,0.1); color: white; border: none; border-radius: 4px; cursor: pointer;',
                                'confirm' => 'Regenerar a URL invalidará a URL anterior. Continuar?'
                            ]
                        ) ?>
                    </div>
                </div>
                
                <?php if ($paymentMethod->provider === 'stripe'): ?>
                <div class="warning-box">
                    <p>⚠️ <strong>Importante:</strong> No Stripe, você também precisa configurar o <strong>Webhook Signing Secret</strong> 
                    que é gerado ao criar o webhook no dashboard.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Payment Methods -->
        <div class="config-card">
            <div class="config-card__header">
                <h3>💳 Métodos de Pagamento Aceitos</h3>
            </div>
            <div class="config-card__body">
                <?php
                $supportedMethods = $paymentMethod->supported_methods ?? [];
                foreach ($paymentTypes as $type => $label):
                    $checked = in_array($type, $supportedMethods);
                    $icons = [
                        'credit_card' => '💳',
                        'debit_card' => '💳',
                        'pix' => '📱',
                        'boleto' => '📄',
                        'cash' => '💵',
                    ];
                ?>
                <label class="form-check">
                    <input type="checkbox" 
                           name="supported_methods[]" 
                           value="<?= $type ?>" 
                           <?= $checked ? 'checked' : '' ?>>
                    <span class="form-check-label">
                        <strong><?= $icons[$type] ?? '•' ?> <?= h($label) ?></strong>
                        <small>
                            <?php
                            echo match ($type) {
                                'credit_card' => 'Visa, Mastercard, Elo, Amex, etc.',
                                'debit_card' => 'Débito Visa, Mastercard Débito',
                                'pix' => 'Pagamento instantâneo via QR Code',
                                'boleto' => 'Boleto bancário com vencimento',
                                'cash' => 'Pagamento em dinheiro na entrega',
                                default => '',
                            };
                            ?>
                        </small>
                    </span>
                </label>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Fees -->
        <div class="config-card">
            <div class="config-card__header">
                <h3>💰 Taxas e Limites</h3>
            </div>
            <div class="config-card__body">
                <div class="form-row">
                    <div class="form-group">
                        <label>Taxa Percentual (%)</label>
                        <?= $this->Form->control('fee_percentage', [
                            'label' => false,
                            'class' => 'form-control',
                            'type' => 'number',
                            'step' => '0.01',
                            'min' => 0,
                            'placeholder' => '2.99'
                        ]) ?>
                    </div>
                    
                    <div class="form-group">
                        <label>Taxa Fixa (R$)</label>
                        <?= $this->Form->control('fee_fixed', [
                            'label' => false,
                            'class' => 'form-control',
                            'type' => 'number',
                            'step' => '0.01',
                            'min' => 0,
                            'placeholder' => '0.39'
                        ]) ?>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Valor Mínimo (R$)</label>
                        <?= $this->Form->control('min_amount', [
                            'label' => false,
                            'class' => 'form-control',
                            'type' => 'number',
                            'step' => '0.01',
                            'min' => 0,
                            'placeholder' => '5.00'
                        ]) ?>
                    </div>
                    
                    <div class="form-group">
                        <label>Valor Máximo (R$)</label>
                        <?= $this->Form->control('max_amount', [
                            'label' => false,
                            'class' => 'form-control',
                            'type' => 'number',
                            'step' => '0.01',
                            'min' => 0,
                            'placeholder' => '10000.00'
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Submit -->
        <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
            <?= $this->Form->button('💾 Salvar Configurações', ['class' => 'btn btn-primary']) ?>
            <?= $this->Html->link('Cancelar', ['action' => 'index'], ['class' => 'btn btn-outline']) ?>
        </div>
        
        <?= $this->Form->end() ?>
    </div>
    
    <!-- Sidebar -->
    <div class="config-sidebar">
        <div class="sidebar-card" style="margin-bottom: 1.5rem;">
            <div class="sidebar-card__header">
                <h4>📊 Status da Integração</h4>
            </div>
            <div class="sidebar-card__body">
                <dl class="status-list">
                    <div>
                        <dt>Gateway</dt>
                        <dd><?= h($providers[$paymentMethod->provider] ?? $paymentMethod->provider) ?></dd>
                    </div>
                    <div>
                        <dt>Ambiente</dt>
                        <dd>
                            <span class="status-indicator">
                                <span class="status-dot <?= $paymentMethod->environment === 'production' ? 'active' : 'warning' ?>"></span>
                                <?= $paymentMethod->environment === 'production' ? 'Produção' : 'Sandbox' ?>
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt>Status</dt>
                        <dd>
                            <span class="status-indicator">
                                <span class="status-dot <?= $paymentMethod->is_active ? 'active' : 'inactive' ?>"></span>
                                <?= $paymentMethod->is_active ? 'Ativo' : 'Inativo' ?>
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt>API Key</dt>
                        <dd>
                            <span class="status-indicator">
                                <span class="status-dot <?= !empty($paymentMethod->api_key) ? 'active' : 'inactive' ?>"></span>
                                <?= !empty($paymentMethod->api_key) ? 'Configurada' : 'Não configurada' ?>
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt>Webhook</dt>
                        <dd>
                            <span class="status-indicator">
                                <span class="status-dot <?= !empty($paymentMethod->webhook_url) ? 'active' : 'inactive' ?>"></span>
                                <?= !empty($paymentMethod->webhook_url) ? 'Configurado' : 'Não configurado' ?>
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
        
        <div class="sidebar-card">
            <div class="sidebar-card__header" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                <h4>📚 Documentação</h4>
            </div>
            <div class="sidebar-card__body">
                <?php
                $docs = [
                    'pagarme' => [
                        'url' => 'https://docs.pagar.me/',
                        'name' => 'Documentação Pagar.me'
                    ],
                    'pagseguro' => [
                        'url' => 'https://dev.pagbank.uol.com.br/',
                        'name' => 'Documentação PagSeguro'
                    ],
                    'stripe' => [
                        'url' => 'https://stripe.com/docs',
                        'name' => 'Documentação Stripe'
                    ],
                ];
                
                if (isset($docs[$paymentMethod->provider])):
                ?>
                <a href="<?= $docs[$paymentMethod->provider]['url'] ?>" target="_blank" class="help-link" style="font-size: 0.875rem;">
                    📖 <?= $docs[$paymentMethod->provider]['name'] ?> ↗
                </a>
                <?php endif; ?>
                
                <hr style="margin: 1rem 0; border: none; border-top: 1px solid #e5e7eb;">
                
                <p style="font-size: 0.8125rem; color: #64748b; margin: 0;">
                    Configure as credenciais corretamente para processar pagamentos. 
                    Use o modo Sandbox para testes antes de ir para Produção.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
function copyWebhookUrl() {
    const url = document.getElementById('webhook-url').textContent;
    navigator.clipboard.writeText(url).then(() => {
        alert('URL copiada para a área de transferência!');
    }).catch(err => {
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = url;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        alert('URL copiada para a área de transferência!');
    });
}
</script>
