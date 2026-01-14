<?php
/**
 * Login template
 *
 * @var \App\View\AppView $this
 */
?>
<div class="login-card">
    <div class="login-header">
        <div class="login-logo">🍽</div>
        <h1 class="login-title">Digital Menu</h1>
        <p class="login-subtitle">Acesse o painel administrativo</p>
    </div>

    <?= $this->Form->create(null, ['class' => 'login-form']) ?>
    
    <div class="form-group">
        <label class="form-label" for="username">Usuário</label>
        <?= $this->Form->control('username', [
            'label' => false,
            'class' => 'form-control',
            'placeholder' => 'Digite seu usuário',
            'required' => true,
            'autofocus' => true
        ]) ?>
    </div>

    <div class="form-group">
        <label class="form-label" for="password">Senha</label>
        <?= $this->Form->control('password', [
            'label' => false,
            'type' => 'password',
            'class' => 'form-control',
            'placeholder' => 'Digite sua senha',
            'required' => true
        ]) ?>
    </div>

    <?= $this->Form->button(__('Entrar'), ['class' => 'btn-login']) ?>
    
    <?= $this->Form->end() ?>

    <div class="login-footer">
        <a href="<?= $this->Url->build('/') ?>">← Voltar ao site</a>
    </div>
</div>
