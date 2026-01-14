<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Banner> $banners
 */
$this->assign('title', 'Banners');
?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Gerenciar Banners</h2>
        <?= $this->Html->link(__('Novo Banner'), ['action' => 'add'], ['class' => 'btn btn-accent']) ?>
    </div>
    <div class="card-body">
        <div class="banners-grid">
            <?php foreach ($banners as $banner): ?>
            <div class="banner-card <?= $banner->is_active ? 'active' : 'inactive' ?>">
                <div class="banner-image">
                    <img src="<?= h($banner->image_url) ?>" alt="<?= h($banner->title) ?>" onerror="this.src='https://via.placeholder.com/400x200?text=Imagem+não+encontrada'">
                    <div class="banner-status">
                        <?php if ($banner->is_active): ?>
                            <span class="status-badge active">Ativo</span>
                        <?php else: ?>
                            <span class="status-badge inactive">Inativo</span>
                        <?php endif; ?>
                    </div>
                    <div class="banner-position">#<?= $banner->position ?></div>
                </div>
                <div class="banner-info">
                    <h3><?= h($banner->title) ?: 'Sem título' ?></h3>
                    <p class="restaurant-name">
                        <?= $banner->hasValue('restaurant') ? h($banner->restaurant->name) : '' ?>
                    </p>
                    <?php if ($banner->link_url): ?>
                    <p class="link-url">
                        <small>Link: <?= h($banner->link_url) ?></small>
                    </p>
                    <?php endif; ?>
                </div>
                <div class="banner-actions">
                    <?= $this->Form->postLink(
                        $banner->is_active ? __('Desativar') : __('Ativar'),
                        ['action' => 'toggleActive', $banner->id],
                        ['class' => 'btn btn-sm ' . ($banner->is_active ? 'btn-warning' : 'btn-success')]
                    ) ?>
                    <?= $this->Html->link(__('Editar'), ['action' => 'edit', $banner->id], ['class' => 'btn btn-accent btn-sm']) ?>
                    <?= $this->Form->postLink(
                        __('Excluir'),
                        ['action' => 'delete', $banner->id],
                        [
                            'confirm' => __('Tem certeza que deseja excluir este banner?'),
                            'class' => 'btn btn-danger btn-sm'
                        ]
                    ) ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php if (empty($banners->toArray())): ?>
        <div class="empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <p>Nenhum banner cadastrado</p>
            <?= $this->Html->link(__('Criar primeiro banner'), ['action' => 'add'], ['class' => 'btn btn-accent']) ?>
        </div>
        <?php endif; ?>
    </div>
    <?php if (!empty($banners->toArray())): ?>
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
    <?php endif; ?>
</div>

<style>
.banners-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 1.5rem;
}

.banner-card {
    background: var(--bg-content);
    border-radius: 12px;
    overflow: hidden;
    border: 2px solid transparent;
    transition: all 0.2s ease;
}

.banner-card.active {
    border-color: rgba(16, 185, 129, 0.3);
}

.banner-card.inactive {
    border-color: rgba(239, 68, 68, 0.3);
    opacity: 0.7;
}

.banner-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow);
}

.banner-image {
    position: relative;
    width: 100%;
    height: 180px;
    background: #e2e8f0;
}

.banner-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.banner-status {
    position: absolute;
    top: 0.75rem;
    right: 0.75rem;
}

.banner-position {
    position: absolute;
    top: 0.75rem;
    left: 0.75rem;
    background: rgba(0,0,0,0.6);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 600;
}

.status-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
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

.banner-info {
    padding: 1rem;
}

.banner-info h3 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
}

.banner-info .restaurant-name {
    font-size: 0.875rem;
    color: var(--primary);
    margin-bottom: 0.25rem;
}

.banner-info .link-url {
    font-size: 0.75rem;
    color: var(--text-muted);
    word-break: break-all;
}

.banner-actions {
    padding: 0 1rem 1rem;
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
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

.empty-state {
    text-align: center;
    padding: 3rem 1rem;
    color: var(--text-muted);
}

.empty-state svg {
    margin-bottom: 1rem;
    opacity: 0.5;
}

.empty-state p {
    font-size: 1rem;
    margin-bottom: 1rem;
}
</style>
