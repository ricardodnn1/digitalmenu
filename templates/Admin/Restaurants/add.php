<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Restaurant $restaurant
 */
$this->assign('title', 'Novo Restaurante');
?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Novo Restaurante</h2>
        <?= $this->Html->link(__('Voltar'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
    </div>
    <div class="card-body">
        <?= $this->Form->create($restaurant) ?>
        <div class="form-group">
            <?= $this->Form->control('name', [
                'label' => 'Nome *',
                'class' => 'form-control',
                'placeholder' => 'Nome do restaurante'
            ]) ?>
        </div>
        <div class="form-group">
            <?= $this->Form->control('logo_url', [
                'label' => 'URL do Logo',
                'class' => 'form-control',
                'placeholder' => 'https://exemplo.com/logo.png'
            ]) ?>
        </div>
        <div class="form-group">
            <?= $this->Form->control('qrcode_url', [
                'label' => 'URL do QR Code',
                'class' => 'form-control',
                'placeholder' => 'https://exemplo.com/qrcode.png'
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
