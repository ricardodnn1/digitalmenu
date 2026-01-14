<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Banner $banner
 */
$this->assign('title', 'Banner: ' . ($banner->title ?: '#' . $banner->id));
?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Detalhes do Banner</h2>
        <div>
            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $banner->id], ['class' => 'btn btn-accent']) ?>
            <?= $this->Html->link(__('Voltar'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <div class="card-body">
        <div class="banner-view-layout">
            <div class="banner-preview">
                <img src="<?= h($banner->image_url) ?>" alt="<?= h($banner->title) ?>" onerror="this.src='https://via.placeholder.com/600x300?text=Imagem+não+encontrada'">
                <div class="banner-overlay">
                    <?php if ($banner->is_active): ?>
                        <span class="status-badge active">Ativo</span>
                    <?php else: ?>
                        <span class="status-badge inactive">Inativo</span>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="banner-details">
                <div class="detail-grid">
                    <div class="detail-item">
                        <label>ID</label>
                        <span><?= $this->Number->format($banner->id) ?></span>
                    </div>
                    <div class="detail-item">
                        <label>Título</label>
                        <span><?= h($banner->title) ?: 'Sem título' ?></span>
                    </div>
                    <div class="detail-item">
                        <label>Restaurante</label>
                        <span><?= $banner->hasValue('restaurant') ? $this->Html->link($banner->restaurant->name, ['controller' => 'Restaurants', 'action' => 'view', $banner->restaurant->id]) : '-' ?></span>
                    </div>
                    <div class="detail-item">
                        <label>Posição</label>
                        <span><?= $this->Number->format($banner->position) ?></span>
                    </div>
                    <div class="detail-item full-width">
                        <label>URL da Imagem</label>
                        <span><code><?= h($banner->image_url) ?></code></span>
                    </div>
                    <div class="detail-item full-width">
                        <label>Link de Destino</label>
                        <span>
                            <?php if ($banner->link_url): ?>
                                <a href="<?= h($banner->link_url) ?>" target="_blank"><?= h($banner->link_url) ?></a>
                            <?php else: ?>
                                <em>Nenhum link definido</em>
                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="detail-item">
                        <label>Criado em</label>
                        <span><?= $banner->created_at ? $banner->created_at->format('d/m/Y H:i') : '' ?></span>
                    </div>
                    <div class="detail-item">
                        <label>Atualizado em</label>
                        <span><?= $banner->updated_at ? $banner->updated_at->format('d/m/Y H:i') : '' ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="banner-actions-footer">
            <?= $this->Form->postLink(
                $banner->is_active ? __('Desativar Banner') : __('Ativar Banner'),
                ['action' => 'toggleActive', $banner->id],
                ['class' => 'btn ' . ($banner->is_active ? 'btn-warning' : 'btn-success')]
            ) ?>
            <?= $this->Form->postLink(
                __('Excluir Banner'),
                ['action' => 'delete', $banner->id],
                [
                    'confirm' => __('Tem certeza que deseja excluir este banner?'),
                    'class' => 'btn btn-danger'
                ]
            ) ?>
        </div>
    </div>
</div>

<style>
.banner-view-layout {
    display: grid;
    gap: 2rem;
}

.banner-preview {
    position: relative;
    width: 100%;
    max-width: 600px;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: var(--shadow);
}

.banner-preview img {
    width: 100%;
    display: block;
}

.banner-overlay {
    position: absolute;
    top: 1rem;
    right: 1rem;
}

.status-badge {
    display: inline-block;
    padding: 0.375rem 1rem;
    border-radius: 9999px;
    font-size: 0.875rem;
    font-weight: 600;
}

.status-badge.active {
    background: rgba(16, 185, 129, 0.9);
    color: white;
}

.status-badge.inactive {
    background: rgba(239, 68, 68, 0.9);
    color: white;
}

.detail-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.detail-item.full-width {
    grid-column: 1 / -1;
}

.detail-item label {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.detail-item span {
    font-size: 1rem;
    color: var(--text-dark);
}

.detail-item code {
    background: #f1f5f9;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.875rem;
    word-break: break-all;
}

.detail-item a {
    color: var(--primary);
    text-decoration: none;
    word-break: break-all;
}

.detail-item a:hover {
    text-decoration: underline;
}

.banner-actions-footer {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e2e8f0;
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
