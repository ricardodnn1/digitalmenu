<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AdminUser $adminUser
 * @var \Cake\Collection\CollectionInterface|string[] $restaurants
 */
$this->assign('title', 'Novo Usuário Admin');
?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Novo Usuário Admin</h2>
        <?= $this->Html->link(__('Voltar'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
    </div>
    <div class="card-body">
        <?= $this->Form->create($adminUser) ?>
        <div class="form-group">
            <?= $this->Form->control('username', [
                'label' => 'Nome de Usuário *',
                'class' => 'form-control',
                'placeholder' => 'Nome de usuário único'
            ]) ?>
        </div>
        <div class="form-group">
            <?= $this->Form->control('password', [
                'label' => 'Senha *',
                'class' => 'form-control',
                'type' => 'password',
                'placeholder' => 'Senha de acesso'
            ]) ?>
        </div>
        <div class="form-group">
            <?= $this->Form->control('restaurant_id', [
                'label' => 'Restaurante *',
                'options' => $restaurants,
                'empty' => 'Selecione um restaurante',
                'class' => 'form-control'
            ]) ?>
        </div>
        <div class="form-actions">
            <?= $this->Form->button(__('Salvar'), ['class' => 'btn btn-accent']) ?>
            <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>

<style>
.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e2e8f0;
}
</style>
