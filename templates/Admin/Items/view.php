<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Item $item
 */
$this->assign('title', 'Produto: ' . $item->name);
?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title"><?= h($item->name) ?></h2>
        <div>
            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $item->id], ['class' => 'btn btn-accent']) ?>
            <?= $this->Html->link(__('Voltar'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <div class="card-body">
        <div class="item-view-grid">
            <?php if ($item->image_url): ?>
            <div class="item-image">
                <img src="<?= h($item->image_url) ?>" alt="<?= h($item->name) ?>">
            </div>
            <?php endif; ?>
            <div class="item-details">
                <div class="detail-grid">
                    <div class="detail-item">
                        <label>ID</label>
                        <span><?= $this->Number->format($item->id) ?></span>
                    </div>
                    <div class="detail-item">
                        <label>Nome</label>
                        <span><?= h($item->name) ?></span>
                    </div>
                    <div class="detail-item">
                        <label>Categoria</label>
                        <span><?= $item->hasValue('category') ? $this->Html->link($item->category->name, ['controller' => 'Categories', 'action' => 'view', $item->category->id]) : '-' ?></span>
                    </div>
                    <div class="detail-item">
                        <label>Preço</label>
                        <span class="price">R$ <?= $this->Number->format($item->price, ['places' => 2]) ?></span>
                    </div>
                    <div class="detail-item">
                        <label>Descrição</label>
                        <span><?= h($item->description) ?: '-' ?></span>
                    </div>
                    <div class="detail-item">
                        <label>Disponibilidade</label>
                        <span>
                            <?php if ($item->available): ?>
                                <span class="badge badge-success">Disponível</span>
                            <?php else: ?>
                                <span class="badge badge-danger">Indisponível</span>
                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="detail-item">
                        <label>Criado em</label>
                        <span><?= $item->created_at ? $item->created_at->format('d/m/Y H:i') : '' ?></span>
                    </div>
                    <div class="detail-item">
                        <label>Atualizado em</label>
                        <span><?= $item->updated_at ? $item->updated_at->format('d/m/Y H:i') : '' ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.item-view-grid {
    display: grid;
    grid-template-columns: 200px 1fr;
    gap: 2rem;
}
.item-image img {
    width: 100%;
    border-radius: 12px;
    box-shadow: var(--shadow);
}
.detail-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}
.detail-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}
.detail-item label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.detail-item span {
    font-size: 1rem;
    color: var(--text-dark);
}
.detail-item .price {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--accent);
}
.badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
}
.badge-success {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
}
.badge-danger {
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
}
@media (max-width: 768px) {
    .item-view-grid {
        grid-template-columns: 1fr;
    }
    .item-image {
        max-width: 200px;
    }
}
</style>
