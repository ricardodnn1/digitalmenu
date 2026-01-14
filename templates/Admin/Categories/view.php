<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
$this->assign('title', 'Categoria: ' . $category->name);
?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title"><?= h($category->name) ?></h2>
        <div>
            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $category->id], ['class' => 'btn btn-accent']) ?>
            <?= $this->Html->link(__('Voltar'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <div class="card-body">
        <div class="detail-grid">
            <div class="detail-item">
                <label>ID</label>
                <span><?= $this->Number->format($category->id) ?></span>
            </div>
            <div class="detail-item">
                <label>Nome</label>
                <span><?= h($category->name) ?></span>
            </div>
            <div class="detail-item">
                <label>Restaurante</label>
                <span><?= $category->hasValue('restaurant') ? $this->Html->link($category->restaurant->name, ['controller' => 'Restaurants', 'action' => 'view', $category->restaurant->id]) : '-' ?></span>
            </div>
            <div class="detail-item">
                <label>Ordem</label>
                <span><?= $this->Number->format($category->order_index) ?></span>
            </div>
            <div class="detail-item">
                <label>Criado em</label>
                <span><?= $category->created_at ? $category->created_at->format('d/m/Y H:i') : '' ?></span>
            </div>
            <div class="detail-item">
                <label>Atualizado em</label>
                <span><?= $category->updated_at ? $category->updated_at->format('d/m/Y H:i') : '' ?></span>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($category->items)): ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Produtos desta Categoria</h3>
        <?= $this->Html->link(__('Novo Produto'), ['controller' => 'Items', 'action' => 'add'], ['class' => 'btn btn-accent']) ?>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Disponível</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($category->items as $item): ?>
                <tr>
                    <td><?= $this->Number->format($item->id) ?></td>
                    <td><?= $this->Html->link($item->name, ['controller' => 'Items', 'action' => 'view', $item->id]) ?></td>
                    <td>R$ <?= $this->Number->format($item->price, ['places' => 2]) ?></td>
                    <td>
                        <?php if ($item->available): ?>
                            <span class="badge badge-success">Sim</span>
                        <?php else: ?>
                            <span class="badge badge-danger">Não</span>
                        <?php endif; ?>
                    </td>
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
</style>
