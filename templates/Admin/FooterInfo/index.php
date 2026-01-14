<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FooterInfo|null $footerInfo
 * @var \Cake\Collection\CollectionInterface|string[] $restaurants
 * @var string|null $restaurantId
 * @var \App\Model\Entity\Restaurant|null $selectedRestaurant
 */
$this->assign('title', 'Informações do Rodapé');
?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Gerenciar Rodapé (Footer)</h2>
    </div>
    <div class="card-body">
        <!-- Seletor de Restaurante -->
        <div class="restaurant-selector">
            <?= $this->Form->create(null, ['type' => 'get', 'class' => 'selector-form']) ?>
            <div class="form-row">
                <div class="form-group" style="flex: 1;">
                    <?= $this->Form->control('restaurant_id', [
                        'label' => 'Selecione o Restaurante',
                        'options' => $restaurants,
                        'empty' => '-- Selecione um restaurante --',
                        'value' => $restaurantId,
                        'class' => 'form-control',
                        'id' => 'restaurant-selector'
                    ]) ?>
                </div>
                <div class="form-group" style="align-self: flex-end;">
                    <?= $this->Form->button(__('Visualizar'), ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
            <?= $this->Form->end() ?>
        </div>

        <?php if ($restaurantId && $footerInfo): ?>
        <hr style="margin: 2rem 0; border-color: #e2e8f0;">
        
        <div class="footer-header">
            <h3><?= h($selectedRestaurant->name) ?> - Informações do Rodapé</h3>
            <?= $this->Html->link(__('Editar Informações'), ['action' => 'edit', $restaurantId], ['class' => 'btn btn-accent']) ?>
        </div>

        <!-- Preview do Footer -->
        <div class="footer-preview">
            <div class="preview-title">Pré-visualização</div>
            <div class="footer-mock">
                <div class="footer-section">
                    <h4>Contato</h4>
                    <?php if ($footerInfo->address): ?>
                        <p><span class="icon">📍</span> <?= h($footerInfo->address) ?></p>
                    <?php endif; ?>
                    <?php if ($footerInfo->phone): ?>
                        <p><span class="icon">📞</span> <?= h($footerInfo->phone) ?></p>
                    <?php endif; ?>
                    <?php if ($footerInfo->email): ?>
                        <p><span class="icon">✉️</span> <?= h($footerInfo->email) ?></p>
                    <?php endif; ?>
                    <?php if ($footerInfo->whatsapp): ?>
                        <p><span class="icon">💬</span> <?= h($footerInfo->whatsapp) ?></p>
                    <?php endif; ?>
                </div>

                <?php if ($footerInfo->hasSocialMedia()): ?>
                <div class="footer-section">
                    <h4>Redes Sociais</h4>
                    <div class="social-icons">
                        <?php if ($footerInfo->instagram_url): ?>
                            <a href="<?= h($footerInfo->instagram_url) ?>" target="_blank" class="social-icon instagram" title="Instagram">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </a>
                        <?php endif; ?>
                        <?php if ($footerInfo->facebook_url): ?>
                            <a href="<?= h($footerInfo->facebook_url) ?>" target="_blank" class="social-icon facebook" title="Facebook">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                        <?php endif; ?>
                        <?php if ($footerInfo->twitter_url): ?>
                            <a href="<?= h($footerInfo->twitter_url) ?>" target="_blank" class="social-icon twitter" title="Twitter/X">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            </a>
                        <?php endif; ?>
                        <?php if ($footerInfo->tiktok_url): ?>
                            <a href="<?= h($footerInfo->tiktok_url) ?>" target="_blank" class="social-icon tiktok" title="TikTok">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php if ($footerInfo->additional_info): ?>
                <div class="footer-section full-width">
                    <h4>Informações Adicionais</h4>
                    <p><?= nl2br(h($footerInfo->additional_info)) ?></p>
                </div>
                <?php endif; ?>

                <div class="footer-copyright">
                    <?= h($footerInfo->copyright_text) ?: '© ' . date('Y') . ' - Todos os direitos reservados' ?>
                </div>
            </div>
        </div>

        <?php elseif ($restaurantId): ?>
        <div class="empty-state">
            <p>Nenhuma informação cadastrada para este restaurante.</p>
            <?= $this->Html->link(__('Cadastrar Informações'), ['action' => 'edit', $restaurantId], ['class' => 'btn btn-accent']) ?>
        </div>
        <?php else: ?>
        <div class="empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            <p>Selecione um restaurante para visualizar ou editar as informações do rodapé.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
.selector-form .form-row {
    display: flex;
    gap: 1rem;
    align-items: flex-end;
}

.footer-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.footer-header h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-dark);
}

.footer-preview {
    background: var(--bg-content);
    border-radius: 12px;
    padding: 1rem;
    border: 1px solid #e2e8f0;
}

.preview-title {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 1rem;
}

.footer-mock {
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    color: #f1f5f9;
    padding: 2rem;
    border-radius: 8px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 2rem;
}

.footer-section h4 {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: #ed8936;
}

.footer-section p {
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
}

.footer-section .icon {
    font-size: 1rem;
}

.footer-section.full-width {
    grid-column: 1 / -1;
}

.social-icons {
    display: flex;
    gap: 0.75rem;
}

.social-icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.social-icon svg {
    width: 20px;
    height: 20px;
}

.social-icon.instagram { background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); color: white; }
.social-icon.facebook { background: #1877f2; color: white; }
.social-icon.twitter { background: #000; color: white; }
.social-icon.tiktok { background: #000; color: white; }

.social-icon:hover {
    transform: scale(1.1);
}

.footer-copyright {
    grid-column: 1 / -1;
    text-align: center;
    padding-top: 1.5rem;
    border-top: 1px solid #334155;
    font-size: 0.875rem;
    color: #94a3b8;
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

hr {
    border: none;
    border-top: 1px solid #e2e8f0;
}
</style>

<script>
document.getElementById('restaurant-selector').addEventListener('change', function() {
    if (this.value) {
        this.form.submit();
    }
});
</script>
