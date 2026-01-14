<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Category> $categories
 */
$this->assign('title', 'Categorias');
?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Lista de Categorias</h2>
        <?= $this->Html->link(__('Nova Categoria'), ['action' => 'add'], ['class' => 'btn btn-accent']) ?>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                    <th><?= $this->Paginator->sort('name', 'Nome') ?></th>
                    <th><?= $this->Paginator->sort('restaurant_id', 'Restaurante') ?></th>
                    <th><?= $this->Paginator->sort('order_index', 'Ordem') ?></th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?= $this->Number->format($category->id) ?></td>
                    <td><?= h($category->name) ?></td>
                    <td><?= $category->hasValue('restaurant') ? $this->Html->link($category->restaurant->name, ['controller' => 'Restaurants', 'action' => 'view', $category->restaurant->id]) : '' ?></td>
                    <td><?= $this->Number->format($category->order_index) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $category->id], ['class' => 'btn btn-primary btn-sm']) ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $category->id], ['class' => 'btn btn-accent btn-sm']) ?>
                        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $category->id], ['confirm' => __('Tem certeza que deseja excluir a categoria {0}?', $category->name), 'class' => 'btn btn-danger btn-sm']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($categories->toArray())): ?>
                <tr>
                    <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 2rem;">
                        Nenhuma categoria encontrada
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
