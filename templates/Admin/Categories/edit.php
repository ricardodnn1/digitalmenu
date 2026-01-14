<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 * @var \Cake\Collection\CollectionInterface|string[] $restaurants
 */
$this->assign('title', 'Editar Categoria');
?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Editar Categoria</h2>
        <?= $this->Html->link(__('Voltar'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
    </div>
    <div class="card-body">
        <?= $this->Form->create($category) ?>
        <div class="form-group">
            <?= $this->Form->control('restaurant_id', [
                'label' => 'Restaurante *',
                'options' => $restaurants,
                'class' => 'form-control'
            ]) ?>
        </div>
        <div class="form-group">
            <?= $this->Form->control('name', [
                'label' => 'Nome *',
                'class' => 'form-control',
                'placeholder' => 'Nome da categoria'
            ]) ?>
        </div>
        <div class="form-group">
            <?= $this->Form->control('order_index', [
                'label' => 'Ordem de Exibição',
                'class' => 'form-control',
                'type' => 'number'
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
