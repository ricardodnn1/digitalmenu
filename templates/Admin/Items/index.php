<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Item> $items
 */
$this->assign('title', 'Produtos');
?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Lista de Produtos</h2>
        <?= $this->Html->link(__('Novo Produto'), ['action' => 'add'], ['class' => 'btn btn-accent']) ?>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                    <th><?= $this->Paginator->sort('name', 'Nome') ?></th>
                    <th><?= $this->Paginator->sort('category_id', 'Categoria') ?></th>
                    <th><?= $this->Paginator->sort('price', 'Preço') ?></th>
                    <th><?= $this->Paginator->sort('available', 'Status') ?></th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= $this->Number->format($item->id) ?></td>
                    <td>
                        <?php if ($item->image_url): ?>
                            <img src="<?= h($item->image_url) ?>" alt="<?= h($item->name) ?>" style="width: 40px; height: 40px; object-fit: cover; border-radius: 8px; margin-right: 0.5rem; vertical-align: middle;">
                        <?php endif; ?>
                        <?= h($item->name) ?>
                    </td>
                    <td><?= $item->hasValue('category') ? $this->Html->link($item->category->name, ['controller' => 'Categories', 'action' => 'view', $item->category->id]) : '' ?></td>
                    <td>R$ <?= $this->Number->format($item->price, ['places' => 2]) ?></td>
                    <td>
                        <?php if ($item->available): ?>
                            <span class="badge badge-success">Disponível</span>
                        <?php else: ?>
                            <span class="badge badge-danger">Indisponível</span>
                        <?php endif; ?>
                    </td>
                    <td class="actions">
                        <?= $this->Form->postLink(
                            $item->available ? __('Desativar') : __('Ativar'),
                            ['action' => 'toggleAvailable', $item->id],
                            ['class' => 'btn btn-sm ' . ($item->available ? 'btn-warning' : 'btn-success')]
                        ) ?>
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $item->id], ['class' => 'btn btn-primary btn-sm']) ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $item->id], ['class' => 'btn btn-accent btn-sm']) ?>
                        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $item->id], ['confirm' => __('Tem certeza que deseja excluir o produto {0}?', $item->name), 'class' => 'btn btn-danger btn-sm']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($items->toArray())): ?>
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 2rem;">
                        Nenhum produto encontrado
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
.badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
}
.badge-success {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
}
.badge-danger {
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
}
.btn-warning {
    background: var(--warning);
    color: white;
}
.btn-warning:hover {
    background: #d97706;
}
.btn-success {
    background: var(--success);
    color: white;
}
.btn-success:hover {
    background: #059669;
}
</style>
