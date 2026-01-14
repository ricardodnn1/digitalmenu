<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccessLog $accessLog
 */
$this->assign('title', 'Log de Acesso #' . $accessLog->id);
?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Log de Acesso #<?= $accessLog->id ?></h2>
        <div>
            <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $accessLog->id], ['confirm' => __('Tem certeza que deseja excluir este log?'), 'class' => 'btn btn-danger']) ?>
            <?= $this->Html->link(__('Voltar'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <div class="card-body">
        <div class="detail-grid">
            <div class="detail-item">
                <label>ID</label>
                <span><?= $this->Number->format($accessLog->id) ?></span>
            </div>
            <div class="detail-item">
                <label>Endpoint</label>
                <span><code><?= h($accessLog->endpoint) ?></code></span>
            </div>
            <div class="detail-item">
                <label>Método HTTP</label>
                <span>
                    <span class="method-badge method-<?= strtolower($accessLog->method) ?>">
                        <?= h($accessLog->method) ?>
                    </span>
                </span>
            </div>
            <div class="detail-item">
                <label>Endereço IP</label>
                <span><code><?= h($accessLog->ip_address) ?></code></span>
            </div>
            <div class="detail-item">
                <label>Restaurante</label>
                <span><?= $accessLog->hasValue('restaurant') ? $this->Html->link($accessLog->restaurant->name, ['controller' => 'Restaurants', 'action' => 'view', $accessLog->restaurant->id]) : '-' ?></span>
            </div>
            <div class="detail-item">
                <label>Data/Hora</label>
                <span><?= $accessLog->created_at ? $accessLog->created_at->format('d/m/Y H:i:s') : '' ?></span>
            </div>
        </div>

        <?php if ($accessLog->user_agent): ?>
        <div class="user-agent-section">
            <label>User Agent</label>
            <code class="user-agent-code"><?= h($accessLog->user_agent) ?></code>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
code {
    background: #f1f5f9;
    padding: 0.125rem 0.375rem;
    border-radius: 4px;
    font-size: 0.875rem;
}
.detail-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}
.detail-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}
.detail-item label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.detail-item span {
    font-size: 1rem;
    color: var(--text-dark);
}
.method-badge {
    display: inline-block;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}
.method-get {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
}
.method-post {
    background: rgba(59, 130, 246, 0.1);
    color: #3b82f6;
}
.method-put, .method-patch {
    background: rgba(245, 158, 11, 0.1);
    color: #f59e0b;
}
.method-delete {
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
}
.user-agent-section {
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e2e8f0;
}
.user-agent-section label {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.5rem;
}
.user-agent-code {
    display: block;
    padding: 1rem;
    word-break: break-all;
    white-space: pre-wrap;
}
</style>
