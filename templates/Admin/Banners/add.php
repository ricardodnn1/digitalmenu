<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Banner $banner
 * @var \Cake\Collection\CollectionInterface|string[] $restaurants
 */
$this->assign('title', 'Novo Banner');
?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Novo Banner</h2>
        <?= $this->Html->link(__('Voltar'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
    </div>
    <div class="card-body">
        <?= $this->Form->create($banner, ['id' => 'banner-form']) ?>
        
        <div class="form-row">
            <div class="form-group">
                <?= $this->Form->control('restaurant_id', [
                    'label' => 'Restaurante *',
                    'options' => $restaurants,
                    'empty' => 'Selecione um restaurante',
                    'class' => 'form-control'
                ]) ?>
            </div>
            <div class="form-group">
                <?= $this->Form->control('title', [
                    'label' => 'Título',
                    'class' => 'form-control',
                    'placeholder' => 'Título do banner (opcional)'
                ]) ?>
            </div>
        </div>

        <div class="form-group">
            <?= $this->Form->control('image_url', [
                'label' => 'URL da Imagem *',
                'class' => 'form-control',
                'placeholder' => 'https://exemplo.com/banner.jpg',
                'id' => 'image-url-input'
            ]) ?>
            <small class="form-hint">Cole a URL de uma imagem hospedada externamente</small>
        </div>

        <div class="image-preview-container">
            <label>Pré-visualização</label>
            <div class="image-preview" id="image-preview">
                <span>A imagem aparecerá aqui</span>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <?= $this->Form->control('link_url', [
                    'label' => 'Link de Destino',
                    'class' => 'form-control',
                    'placeholder' => 'https://exemplo.com/promocao (opcional)'
                ]) ?>
                <small class="form-hint">URL para onde o usuário será redirecionado ao clicar no banner</small>
            </div>
            <div class="form-group">
                <?= $this->Form->control('position', [
                    'label' => 'Posição',
                    'class' => 'form-control',
                    'type' => 'number',
                    'min' => 0,
                    'default' => 0,
                    'placeholder' => '0'
                ]) ?>
                <small class="form-hint">Ordem de exibição (menor = primeiro)</small>
            </div>
        </div>

        <div class="form-group">
            <div class="checkbox-wrapper">
                <?= $this->Form->control('is_active', [
                    'label' => 'Banner ativo (visível no site)',
                    'type' => 'checkbox',
                    'default' => true
                ]) ?>
            </div>
        </div>

        <div class="form-actions">
            <?= $this->Form->button(__('Salvar Banner'), ['class' => 'btn btn-accent']) ?>
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

.form-hint {
    display: block;
    margin-top: 0.375rem;
    font-size: 0.75rem;
    color: var(--text-muted);
}

.image-preview-container {
    margin-bottom: 1.25rem;
}

.image-preview-container label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: var(--text-dark);
}

.image-preview {
    width: 100%;
    max-width: 600px;
    height: 200px;
    background: #f1f5f9;
    border: 2px dashed #e2e8f0;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.image-preview span {
    color: var(--text-muted);
    font-size: 0.875rem;
}

.image-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
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

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e2e8f0;
}
</style>

<script>
document.getElementById('image-url-input').addEventListener('input', function() {
    const preview = document.getElementById('image-preview');
    const url = this.value.trim();
    
    if (url) {
        preview.innerHTML = '<img src="' + url + '" alt="Preview" onerror="this.parentElement.innerHTML=\'<span>Erro ao carregar imagem</span>\'">';
    } else {
        preview.innerHTML = '<span>A imagem aparecerá aqui</span>';
    }
});
</script>
