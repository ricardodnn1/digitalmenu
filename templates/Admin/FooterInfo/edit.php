<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Restaurant $restaurant
 * @var \App\Model\Entity\FooterInfo $footerInfo
 */
$this->assign('title', 'Editar Rodapé - ' . $restaurant->name);
?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">
            <span>Informações do Rodapé</span>
            <small style="font-weight: 400; color: var(--text-muted); font-size: 0.875rem; margin-left: 0.5rem;">
                <?= h($restaurant->name) ?>
            </small>
        </h2>
        <?= $this->Html->link(__('Voltar'), ['action' => 'index', '?' => ['restaurant_id' => $restaurant->id]], ['class' => 'btn btn-primary']) ?>
    </div>
    <div class="card-body">
        <?= $this->Form->create($footerInfo) ?>
        
        <!-- Informações de Contato -->
        <div class="form-section">
            <h3 class="section-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                Informações de Contato
            </h3>
            
            <div class="form-group">
                <?= $this->Form->control('address', [
                    'label' => 'Endereço',
                    'class' => 'form-control',
                    'type' => 'textarea',
                    'rows' => 2,
                    'placeholder' => 'Rua Exemplo, 123 - Bairro - Cidade/UF'
                ]) ?>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <?= $this->Form->control('phone', [
                        'label' => 'Telefone',
                        'class' => 'form-control',
                        'placeholder' => '(11) 1234-5678'
                    ]) ?>
                </div>
                <div class="form-group">
                    <?= $this->Form->control('whatsapp', [
                        'label' => 'WhatsApp',
                        'class' => 'form-control',
                        'placeholder' => '(11) 91234-5678'
                    ]) ?>
                    <small class="form-hint">Número com DDD para link direto</small>
                </div>
            </div>

            <div class="form-group">
                <?= $this->Form->control('email', [
                    'label' => 'E-mail',
                    'class' => 'form-control',
                    'type' => 'email',
                    'placeholder' => 'contato@restaurante.com'
                ]) ?>
            </div>
        </div>

        <!-- Redes Sociais -->
        <div class="form-section">
            <h3 class="section-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                </svg>
                Redes Sociais
            </h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label-with-icon">
                        <span class="social-badge instagram">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073z"/></svg>
                        </span>
                        Instagram
                    </label>
                    <?= $this->Form->control('instagram_url', [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'https://instagram.com/seurestaurante'
                    ]) ?>
                </div>
                <div class="form-group">
                    <label class="form-label-with-icon">
                        <span class="social-badge facebook">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </span>
                        Facebook
                    </label>
                    <?= $this->Form->control('facebook_url', [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'https://facebook.com/seurestaurante'
                    ]) ?>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label-with-icon">
                        <span class="social-badge twitter">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </span>
                        Twitter / X
                    </label>
                    <?= $this->Form->control('twitter_url', [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'https://twitter.com/seurestaurante'
                    ]) ?>
                </div>
                <div class="form-group">
                    <label class="form-label-with-icon">
                        <span class="social-badge tiktok">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                        </span>
                        TikTok
                    </label>
                    <?= $this->Form->control('tiktok_url', [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'https://tiktok.com/@seurestaurante'
                    ]) ?>
                </div>
            </div>
        </div>

        <!-- Informações Adicionais -->
        <div class="form-section">
            <h3 class="section-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Informações Adicionais
            </h3>

            <div class="form-group">
                <?= $this->Form->control('additional_info', [
                    'label' => 'Texto Adicional',
                    'class' => 'form-control',
                    'type' => 'textarea',
                    'rows' => 3,
                    'placeholder' => 'Informações adicionais que deseja exibir no rodapé...'
                ]) ?>
                <small class="form-hint">Ex: Horário especial, promoções, avisos, etc.</small>
            </div>

            <div class="form-group">
                <?= $this->Form->control('copyright_text', [
                    'label' => 'Texto de Copyright',
                    'class' => 'form-control',
                    'placeholder' => '© ' . date('Y') . ' - Nome do Restaurante. Todos os direitos reservados.'
                ]) ?>
            </div>
        </div>

        <div class="form-actions">
            <?= $this->Form->button(__('Salvar Informações'), ['class' => 'btn btn-accent btn-lg']) ?>
            <?= $this->Html->link(__('Cancelar'), ['action' => 'index', '?' => ['restaurant_id' => $restaurant->id]], ['class' => 'btn btn-primary']) ?>
            <?php if ($footerInfo->id): ?>
                <?= $this->Form->postLink(
                    __('Limpar Tudo'),
                    ['action' => 'delete', $footerInfo->id],
                    [
                        'confirm' => __('Tem certeza que deseja remover todas as informações do rodapé?'),
                        'class' => 'btn btn-danger'
                    ]
                ) ?>
            <?php endif; ?>
        </div>
        
        <?= $this->Form->end() ?>
    </div>
</div>

<style>
.form-section {
    background: var(--bg-content);
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    border: 1px solid #e2e8f0;
}

.section-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 1.25rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid #e2e8f0;
}

.section-title svg {
    color: var(--accent);
}

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

.form-label-with-icon {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: var(--text-dark);
}

.social-badge {
    width: 24px;
    height: 24px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.social-badge svg {
    width: 14px;
    height: 14px;
}

.social-badge.instagram { background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); color: white; }
.social-badge.facebook { background: #1877f2; color: white; }
.social-badge.twitter { background: #000; color: white; }
.social-badge.tiktok { background: #000; color: white; }

.btn-lg {
    padding: 0.875rem 2rem;
    font-size: 1rem;
}

.form-actions {
    display: flex;
    gap: 1rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e2e8f0;
}
</style>
