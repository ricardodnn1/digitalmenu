<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Item $item
 * @var \Cake\Collection\CollectionInterface|string[] $categories
 */
$this->assign('title', 'Novo Produto');
?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Novo Produto</h2>
        <?= $this->Html->link(__('Voltar'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
    </div>
    <div class="card-body">
        <?= $this->Form->create($item) ?>
        <div class="form-row">
            <div class="form-group">
                <?= $this->Form->control('category_id', [
                    'label' => 'Categoria *',
                    'options' => $categories,
                    'empty' => 'Selecione uma categoria',
                    'class' => 'form-control'
                ]) ?>
            </div>
            <div class="form-group">
                <?= $this->Form->control('name', [
                    'label' => 'Nome *',
                    'class' => 'form-control',
                    'placeholder' => 'Nome do produto'
                ]) ?>
            </div>
        </div>
        <div class="form-group">
            <?= $this->Form->control('description', [
                'label' => 'Descrição',
                'class' => 'form-control',
                'type' => 'textarea',
                'rows' => 3,
                'placeholder' => 'Descrição detalhada do produto'
            ]) ?>
        </div>
        <div class="form-row">
            <div class="form-group">
                <?= $this->Form->control('price', [
                    'label' => 'Preço *',
                    'class' => 'form-control',
                    'type' => 'number',
                    'step' => '0.01',
                    'min' => '0',
                    'placeholder' => '0.00'
                ]) ?>
            </div>
            <div class="form-group">
                <?= $this->Form->control('image_url', [
                    'label' => 'URL da Imagem',
                    'class' => 'form-control',
                    'placeholder' => 'https://exemplo.com/imagem.jpg'
                ]) ?>
            </div>
        </div>
        <div class="form-group">
            <div class="checkbox-wrapper">
                <?= $this->Form->control('available', [
                    'label' => 'Produto disponível para venda',
                    'type' => 'checkbox',
                    'default' => true
                ]) ?>
            </div>
        </div>
        <div class="form-actions">
            <?= $this->Form->button(__('Salvar'), ['class' => 'btn btn-accent']) ?>
            <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>

<style>
.form-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
}
.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e2e8f0;
}
.checkbox-wrapper {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.checkbox-wrapper input[type="checkbox"] {
    width: 1.25rem;
    height: 1.25rem;
}
</style>
