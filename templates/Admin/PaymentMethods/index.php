<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\PaymentMethod> $paymentMethods
 * @var array $stats
 */

$this->assign('title', 'Métodos de Pagamento');
?>

<style>
    .payment-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 12px;
        padding: 1.5rem;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
    
    .stat-card.success { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
    .stat-card.warning { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
    .stat-card.info { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
    
    .stat-card h3 {
        font-size: 2rem;
        margin: 0 0 0.25rem 0;
        font-weight: 700;
    }
    
    .stat-card p {
        margin: 0;
        opacity: 0.9;
        font-size: 0.875rem;
    }
    
    .payment-methods-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
    }
    
    .payment-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        overflow: hidden;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    
    .payment-card:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        transform: translateY(-2px);
    }
    
    .payment-card.active {
        border-color: #22c55e;
    }
    
    .payment-card.inactive {
        border-color: #ef4444;
        opacity: 0.7;
    }
    
    .payment-card__header {
        padding: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .payment-card__logo {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .payment-card__icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        background: #f8fafc;
    }
    
    .payment-card__icon.pagarme { background: #00d4aa; color: white; }
    .payment-card__icon.pagseguro { background: #00a650; color: white; }
    .payment-card__icon.stripe { background: #635bff; color: white; }
    .payment-card__icon.pix_manual { background: #32bcad; color: white; }
    .payment-card__icon.cash { background: #fbbf24; color: #1a1a2e; }
    
    .payment-card__name h3 {
        margin: 0;
        font-size: 1.125rem;
        font-weight: 600;
    }
    
    .payment-card__name span {
        font-size: 0.75rem;
        color: #64748b;
    }
    
    .payment-card__status {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .status-badge.active {
        background: #dcfce7;
        color: #166534;
    }
    
    .status-badge.inactive {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .env-badge {
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.625rem;
        font-weight: 700;
        text-transform: uppercase;
    }
    
    .env-badge.sandbox {
        background: #fef3c7;
        color: #92400e;
    }
    
    .env-badge.production {
        background: #dbeafe;
        color: #1e40af;
    }
    
    .payment-card__body {
        padding: 1.5rem;
    }
    
    .payment-card__methods {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .method-tag {
        padding: 0.25rem 0.5rem;
        background: #f1f5f9;
        border-radius: 4px;
        font-size: 0.75rem;
        color: #475569;
    }
    
    .payment-card__info {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
        font-size: 0.875rem;
        margin-bottom: 1rem;
    }
    
    .payment-card__info dt {
        color: #64748b;
    }
    
    .payment-card__info dd {
        margin: 0;
        font-weight: 500;
        text-align: right;
    }
    
    .payment-card__actions {
        padding: 1rem 1.5rem;
        background: #f8fafc;
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .btn {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
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
    
    .btn-danger {
        background: #ef4444;
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
    
    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.75rem;
    }
    
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    
    .page-header h1 {
        margin: 0;
        font-size: 1.75rem;
    }
    
    .header-actions {
        display: flex;
        gap: 0.75rem;
    }
    
    .default-badge {
        background: #fef3c7;
        color: #92400e;
        padding: 0.125rem 0.5rem;
        border-radius: 4px;
        font-size: 0.625rem;
        font-weight: 700;
        text-transform: uppercase;
        margin-left: 0.5rem;
    }
</style>

<div class="page-header">
    <h1>💳 Métodos de Pagamento</h1>
    <div class="header-actions">
        <?= $this->Html->link('📊 Transações', ['action' => 'transactions'], ['class' => 'btn btn-outline']) ?>
        <?= $this->Html->link('🔔 Webhooks', ['action' => 'webhooks'], ['class' => 'btn btn-outline']) ?>
        <?= $this->Html->link('➕ Adicionar Método', ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<!-- Stats -->
<div class="payment-stats">
    <div class="stat-card info">
        <h3><?= number_format($stats['total_transactions']) ?></h3>
        <p>Total de Transações</p>
    </div>
    <div class="stat-card warning">
        <h3><?= number_format($stats['pending']) ?></h3>
        <p>Pendentes</p>
    </div>
    <div class="stat-card success">
        <h3><?= number_format($stats['approved']) ?></h3>
        <p>Aprovadas</p>
    </div>
    <div class="stat-card">
        <h3>R$ <?= number_format((float)$stats['total_revenue'], 2, ',', '.') ?></h3>
        <p>Receita Total</p>
    </div>
</div>

<!-- Payment Methods Grid -->
<div class="payment-methods-grid">
    <?php foreach ($paymentMethods as $method): ?>
    <div class="payment-card <?= $method->is_active ? 'active' : 'inactive' ?>">
        <div class="payment-card__header">
            <div class="payment-card__logo">
                <div class="payment-card__icon <?= h($method->provider) ?>">
                    <?php
                    echo match ($method->provider) {
                        'pagarme' => '💎',
                        'pagseguro' => '🛡️',
                        'stripe' => '⚡',
                        'pix_manual' => '📱',
                        'cash' => '💵',
                        default => '💳',
                    };
                    ?>
                </div>
                <div class="payment-card__name">
                    <h3>
                        <?= h($method->name) ?>
                        <?php if ($method->is_default): ?>
                            <span class="default-badge">Padrão</span>
                        <?php endif; ?>
                    </h3>
                    <span><?= h($method->provider) ?></span>
                </div>
            </div>
            <div class="payment-card__status">
                <span class="env-badge <?= $method->environment ?>">
                    <?= $method->environment ?>
                </span>
                <span class="status-badge <?= $method->is_active ? 'active' : 'inactive' ?>">
                    <?= $method->is_active ? 'Ativo' : 'Inativo' ?>
                </span>
            </div>
        </div>
        
        <div class="payment-card__body">
            <div class="payment-card__methods">
                <?php
                $methodLabels = \App\Model\Entity\PaymentMethod::PAYMENT_TYPES;
                foreach ($method->supported_methods ?? [] as $type):
                ?>
                    <span class="method-tag"><?= $methodLabels[$type] ?? $type ?></span>
                <?php endforeach; ?>
            </div>
            
            <dl class="payment-card__info">
                <dt>Taxa:</dt>
                <dd><?= number_format($method->fee_percentage ?? 0, 2) ?>% + R$ <?= number_format($method->fee_fixed ?? 0, 2, ',', '.') ?></dd>
                
                <dt>Mín/Máx:</dt>
                <dd>R$ <?= number_format($method->min_amount ?? 0, 0, ',', '.') ?> - R$ <?= number_format($method->max_amount ?? 999999, 0, ',', '.') ?></dd>
            </dl>
        </div>
        
        <div class="payment-card__actions">
            <?= $this->Html->link('⚙️ Configurar', ['action' => 'configure', $method->id], ['class' => 'btn btn-primary btn-sm']) ?>
            
            <?= $this->Form->postLink(
                $method->is_active ? '🔴 Desativar' : '🟢 Ativar',
                ['action' => 'toggle', $method->id],
                [
                    'class' => 'btn btn-sm ' . ($method->is_active ? 'btn-danger' : 'btn-success'),
                    'confirm' => $method->is_active 
                        ? 'Deseja desativar este método de pagamento?' 
                        : 'Deseja ativar este método de pagamento?'
                ]
            ) ?>
            
            <?php if (!$method->is_default && $method->is_active): ?>
                <?= $this->Form->postLink(
                    '⭐ Definir Padrão',
                    ['action' => 'setDefault', $method->id],
                    ['class' => 'btn btn-outline btn-sm']
                ) ?>
            <?php endif; ?>
            
            <?= $this->Html->link('👁️ Ver', ['action' => 'view', $method->id], ['class' => 'btn btn-outline btn-sm']) ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php if (empty($paymentMethods->toArray())): ?>
<div style="text-align: center; padding: 3rem; background: white; border-radius: 12px; margin-top: 2rem;">
    <p style="font-size: 3rem; margin-bottom: 1rem;">💳</p>
    <h3>Nenhum método de pagamento configurado</h3>
    <p style="color: #64748b; margin-bottom: 1.5rem;">Configure seus gateways de pagamento para começar a receber.</p>
    <?= $this->Html->link('Adicionar Método de Pagamento', ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
</div>
<?php endif; ?>
