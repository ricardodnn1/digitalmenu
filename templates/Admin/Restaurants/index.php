<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Restaurant> $restaurants
 */
$this->assign('title', 'Restaurantes');
?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Lista de Restaurantes</h2>
        <?= $this->Html->link(__('Novo Restaurante'), ['action' => 'add'], ['class' => 'btn btn-accent']) ?>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                    <th><?= $this->Paginator->sort('name', 'Nome') ?></th>
                    <th><?= $this->Paginator->sort('created_at', 'Criado em') ?></th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($restaurants as $restaurant): ?>
                <tr>
                    <td><?= $this->Number->format($restaurant->id) ?></td>
                    <td><?= h($restaurant->name) ?></td>
                    <td><?= $restaurant->created_at ? $restaurant->created_at->format('d/m/Y H:i') : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $restaurant->id], ['class' => 'btn btn-primary btn-sm']) ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $restaurant->id], ['class' => 'btn btn-accent btn-sm']) ?>
                        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $restaurant->id], ['confirm' => __('Tem certeza que deseja excluir o restaurante {0}?', $restaurant->name), 'class' => 'btn btn-danger btn-sm']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($restaurants->toArray())): ?>
                <tr>
                    <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 2rem;">
                        Nenhum restaurante encontrado
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
