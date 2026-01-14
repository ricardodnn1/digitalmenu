<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Restaurant $restaurant
 */
$this->assign('title', 'Restaurante: ' . $restaurant->name);
?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title"><?= h($restaurant->name) ?></h2>
        <div>
            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $restaurant->id], ['class' => 'btn btn-accent']) ?>
            <?= $this->Html->link(__('Voltar'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <div class="card-body">
        <div class="detail-grid">
            <div class="detail-item">
                <label>ID</label>
                <span><?= $this->Number->format($restaurant->id) ?></span>
            </div>
            <div class="detail-item">
                <label>Nome</label>
                <span><?= h($restaurant->name) ?></span>
            </div>
            <div class="detail-item">
                <label>Logo URL</label>
                <span><?= h($restaurant->logo_url) ?: '-' ?></span>
            </div>
            <div class="detail-item">
                <label>QR Code URL</label>
                <span><?= h($restaurant->qrcode_url) ?: '-' ?></span>
            </div>
            <div class="detail-item">
                <label>Criado em</label>
                <span><?= $restaurant->created_at ? $restaurant->created_at->format('d/m/Y H:i') : '' ?></span>
            </div>
            <div class="detail-item">
                <label>Atualizado em</label>
                <span><?= $restaurant->updated_at ? $restaurant->updated_at->format('d/m/Y H:i') : '' ?></span>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($restaurant->categories)): ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Categorias</h3>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Ordem</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($restaurant->categories as $category): ?>
                <tr>
                    <td><?= $this->Number->format($category->id) ?></td>
                    <td><?= $this->Html->link($category->name, ['controller' => 'Categories', 'action' => 'view', $category->id]) ?></td>
                    <td><?= $this->Number->format($category->order_index) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<style>
.detail-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
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
</style>
