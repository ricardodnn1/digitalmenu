<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\WebhookLog> $webhooks
 * @var array $providers
 */

$this->assign('title', 'Logs de Webhook');
?>

<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    
    .page-header h1 {
        margin: 0;
        font-size: 1.5rem;
    }
    
    .filters-bar {
        background: white;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: center;
    }
    
    .filter-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .filter-group label {
        font-size: 0.875rem;
        color: #64748b;
        white-space: nowrap;
    }
    
    .filter-group select {
        padding: 0.5rem 1rem;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        font-size: 0.875rem;
    }
    
    .btn {
        padding: 0.5rem 1rem;
        border-radius: 6px;
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
    
    .btn-outline {
        background: white;
        color: #475569;
        border: 1px solid #e2e8f0;
    }
    
    .btn-outline:hover {
        background: #f8fafc;
    }
    
    .webhooks-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    .webhook-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    
    .webhook-card__header {
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .webhook-card__header-left {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .webhook-card__header-right {
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
    
    .event-type {
        font-family: 'Fira Code', monospace;
        font-size: 0.875rem;
        font-weight: 500;
    }
    
    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .status-badge.processed { background: #dcfce7; color: #166534; }
    .status-badge.pending { background: #fef3c7; color: #92400e; }
    .status-badge.error { background: #fee2e2; color: #991b1b; }
    
    .signature-badge {
        padding: 0.125rem 0.5rem;
        border-radius: 4px;
        font-size: 0.625rem;
        font-weight: 700;
        text-transform: uppercase;
    }
    
    .signature-badge.valid { background: #dcfce7; color: #166534; }
    .signature-badge.invalid { background: #fee2e2; color: #991b1b; }
    
    .webhook-card__body {
        padding: 1rem 1.5rem;
    }
    
    .webhook-meta {
        display: flex;
        gap: 2rem;
        font-size: 0.8125rem;
        color: #64748b;
        margin-bottom: 0.75rem;
    }
    
    .webhook-meta span {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .payload-preview {
        background: #1e293b;
        border-radius: 8px;
        padding: 1rem;
        font-family: 'Fira Code', monospace;
        font-size: 0.75rem;
        color: #94a3b8;
        max-height: 150px;
        overflow: auto;
        white-space: pre-wrap;
        word-break: break-all;
    }
    
    .error-message {
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 6px;
        padding: 0.75rem 1rem;
        margin-top: 0.75rem;
        font-size: 0.8125rem;
        color: #991b1b;
    }
    
    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.25rem;
        padding: 1.5rem;
    }
    
    .pagination a,
    .pagination span {
        padding: 0.5rem 0.75rem;
        border-radius: 6px;
        font-size: 0.875rem;
        text-decoration: none;
        color: #475569;
    }
    
    .pagination a:hover {
        background: #f1f5f9;
    }
    
    .pagination .active {
        background: #1a1a2e;
        color: white;
    }
    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 12px;
    }
    
    .empty-state p {
        color: #64748b;
    }
</style>

<div class="page-header">
    <h1>🔔 Logs de Webhook</h1>
    <?= $this->Html->link('← Voltar', ['action' => 'index'], ['class' => 'btn btn-outline']) ?>
</div>

<!-- Filters -->
<form method="get" class="filters-bar">
    <div class="filter-group">
        <label>Provider:</label>
        <select name="provider">
            <option value="">Todos</option>
            <?php foreach ($providers as $key => $name): ?>
                <option value="<?= $key ?>" <?= $this->request->getQuery('provider') === $key ? 'selected' : '' ?>>
                    <?= h($name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div class="filter-group">
        <label>Status:</label>
        <select name="processed">
            <option value="">Todos</option>
            <option value="1" <?= $this->request->getQuery('processed') === '1' ? 'selected' : '' ?>>Processado</option>
            <option value="0" <?= $this->request->getQuery('processed') === '0' ? 'selected' : '' ?>>Pendente</option>
        </select>
    </div>
    
    <button type="submit" class="btn btn-outline">🔍 Filtrar</button>
</form>

<!-- Webhooks List -->
<?php if (!empty($webhooks->toArray())): ?>
<div class="webhooks-list">
    <?php foreach ($webhooks as $webhook): ?>
    <div class="webhook-card">
        <div class="webhook-card__header">
            <div class="webhook-card__header-left">
                <span class="provider-badge <?= h($webhook->provider) ?>"><?= h($webhook->provider) ?></span>
                <span class="event-type"><?= h($webhook->event_type) ?></span>
            </div>
            <div class="webhook-card__header-right">
                <?php if ($webhook->signature_valid !== null): ?>
                    <span class="signature-badge <?= $webhook->signature_valid ? 'valid' : 'invalid' ?>">
                        <?= $webhook->signature_valid ? '✓ Assinatura válida' : '✗ Assinatura inválida' ?>
                    </span>
                <?php endif; ?>
                <span class="status-badge <?= $webhook->processed ? 'processed' : ($webhook->error_message ? 'error' : 'pending') ?>">
                    <?php
                    if ($webhook->error_message) {
                        echo '✗ Erro';
                    } elseif ($webhook->processed) {
                        echo '✓ Processado';
                    } else {
                        echo '○ Pendente';
                    }
                    ?>
                </span>
            </div>
        </div>
        <div class="webhook-card__body">
            <div class="webhook-meta">
                <span>📅 <?= $webhook->created->format('d/m/Y H:i:s') ?></span>
                <?php if ($webhook->external_id): ?>
                    <span>🔗 <?= h($webhook->external_id) ?></span>
                <?php endif; ?>
                <?php if ($webhook->ip_address): ?>
                    <span>🌐 <?= h($webhook->ip_address) ?></span>
                <?php endif; ?>
                <?php if ($webhook->processed_at): ?>
                    <span>⏱️ Processado em <?= $webhook->processed_at->format('H:i:s') ?></span>
                <?php endif; ?>
            </div>
            
            <details>
                <summary style="cursor: pointer; font-size: 0.8125rem; color: #6366f1; margin-bottom: 0.5rem;">
                    Ver Payload
                </summary>
                <div class="payload-preview"><?= h(json_encode($webhook->payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) ?></div>
            </details>
            
            <?php if ($webhook->error_message): ?>
            <div class="error-message">
                <strong>Erro:</strong> <?= h($webhook->error_message) ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="pagination">
    <?= $this->Paginator->prev('« Anterior') ?>
    <?= $this->Paginator->numbers() ?>
    <?= $this->Paginator->next('Próximo »') ?>
</div>

<?php else: ?>
<div class="empty-state">
    <p style="font-size: 3rem;">🔔</p>
    <h3>Nenhum webhook recebido</h3>
    <p>Os logs de webhook aparecerão aqui quando os gateways enviarem notificações.</p>
</div>
<?php endif; ?>
