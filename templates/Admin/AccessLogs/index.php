<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\AccessLog> $accessLogs
 */
$this->assign('title', 'Logs de Acesso');
?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Logs de Acesso</h2>
        <?= $this->Form->postLink(__('Limpar Todos'), ['action' => 'clearAll'], ['confirm' => __('Tem certeza que deseja excluir TODOS os logs de acesso?'), 'class' => 'btn btn-danger']) ?>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                    <th><?= $this->Paginator->sort('endpoint', 'Endpoint') ?></th>
                    <th><?= $this->Paginator->sort('method', 'Método') ?></th>
                    <th><?= $this->Paginator->sort('ip_address', 'IP') ?></th>
                    <th><?= $this->Paginator->sort('restaurant_id', 'Restaurante') ?></th>
                    <th><?= $this->Paginator->sort('created_at', 'Data/Hora') ?></th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($accessLogs as $accessLog): ?>
                <tr>
                    <td><?= $this->Number->format($accessLog->id) ?></td>
                    <td><code><?= h($accessLog->endpoint) ?></code></td>
                    <td>
                        <span class="method-badge method-<?= strtolower($accessLog->method) ?>">
                            <?= h($accessLog->method) ?>
                        </span>
                    </td>
                    <td><code><?= h($accessLog->ip_address) ?></code></td>
                    <td><?= $accessLog->hasValue('restaurant') ? $this->Html->link($accessLog->restaurant->name, ['controller' => 'Restaurants', 'action' => 'view', $accessLog->restaurant->id]) : '-' ?></td>
                    <td><?= $accessLog->created_at ? $accessLog->created_at->format('d/m/Y H:i:s') : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $accessLog->id], ['class' => 'btn btn-primary btn-sm']) ?>
                        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $accessLog->id], ['confirm' => __('Tem certeza que deseja excluir este log?'), 'class' => 'btn btn-danger btn-sm']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($accessLogs->toArray())): ?>
                <tr>
                    <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 2rem;">
                        Nenhum log de acesso encontrado
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->first('« Primeiro') ?>
                <?= $this->Paginator->prev('‹ Anterior') ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next('Próximo ›') ?>
                <?= $this->Paginator->last('Último »') ?>
            </ul>
            <p class="pagination-info"><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) de {{count}} total')) ?></p>
        </div>
    </div>
</div>

<style>
code {
    background: #f1f5f9;
    padding: 0.125rem 0.375rem;
    border-radius: 4px;
    font-size: 0.875rem;
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
</style>
