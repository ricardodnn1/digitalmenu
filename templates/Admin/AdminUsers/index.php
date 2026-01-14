<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\AdminUser> $adminUsers
 */
$this->assign('title', 'Usuários Admin');
?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Lista de Usuários Admin</h2>
        <?= $this->Html->link(__('Novo Usuário'), ['action' => 'add'], ['class' => 'btn btn-accent']) ?>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                    <th><?= $this->Paginator->sort('username', 'Usuário') ?></th>
                    <th><?= $this->Paginator->sort('restaurant_id', 'Restaurante') ?></th>
                    <th><?= $this->Paginator->sort('created_at', 'Criado em') ?></th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($adminUsers as $adminUser): ?>
                <tr>
                    <td><?= $this->Number->format($adminUser->id) ?></td>
                    <td>
                        <div class="user-info">
                            <div class="user-avatar"><?= strtoupper(substr($adminUser->username, 0, 1)) ?></div>
                            <?= h($adminUser->username) ?>
                        </div>
                    </td>
                    <td><?= $adminUser->hasValue('restaurant') ? $this->Html->link($adminUser->restaurant->name, ['controller' => 'Restaurants', 'action' => 'view', $adminUser->restaurant->id]) : '' ?></td>
                    <td><?= $adminUser->created_at ? $adminUser->created_at->format('d/m/Y H:i') : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $adminUser->id], ['class' => 'btn btn-primary btn-sm']) ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $adminUser->id], ['class' => 'btn btn-accent btn-sm']) ?>
                        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $adminUser->id], ['confirm' => __('Tem certeza que deseja excluir o usuário {0}?', $adminUser->username), 'class' => 'btn btn-danger btn-sm']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($adminUsers->toArray())): ?>
                <tr>
                    <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 2rem;">
                        Nenhum usuário encontrado
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
.user-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
.user-avatar {
    width: 36px;
    height: 36px;
    background: var(--primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 0.875rem;
}
</style>
