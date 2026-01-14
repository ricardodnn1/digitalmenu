<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AdminUser $adminUser
 */
$this->assign('title', 'Usuário: ' . $adminUser->username);
?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">
            <div class="user-info">
                <div class="user-avatar-lg"><?= strtoupper(substr($adminUser->username, 0, 1)) ?></div>
                <?= h($adminUser->username) ?>
            </div>
        </h2>
        <div>
            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $adminUser->id], ['class' => 'btn btn-accent']) ?>
            <?= $this->Html->link(__('Voltar'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <div class="card-body">
        <div class="detail-grid">
            <div class="detail-item">
                <label>ID</label>
                <span><?= $this->Number->format($adminUser->id) ?></span>
            </div>
            <div class="detail-item">
                <label>Nome de Usuário</label>
                <span><?= h($adminUser->username) ?></span>
            </div>
            <div class="detail-item">
                <label>Restaurante</label>
                <span><?= $adminUser->hasValue('restaurant') ? $this->Html->link($adminUser->restaurant->name, ['controller' => 'Restaurants', 'action' => 'view', $adminUser->restaurant->id]) : '-' ?></span>
            </div>
            <div class="detail-item">
                <label>Criado em</label>
                <span><?= $adminUser->created_at ? $adminUser->created_at->format('d/m/Y H:i') : '' ?></span>
            </div>
        </div>
    </div>
</div>

<style>
.user-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
.user-avatar-lg {
    width: 48px;
    height: 48px;
    background: var(--primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 1.25rem;
}
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
