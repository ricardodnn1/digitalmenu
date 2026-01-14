<?php
/**
 * Customer Registration Page
 *
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer $customer
 */

$this->assign('title', 'Criar conta');
?>

<section class="auth-page">
    <div class="auth-container">
        <div class="auth-card auth-card--register">
            <div class="auth-card__header">
                <a href="<?= $this->Url->build('/shop') ?>" class="auth-card__logo">
                    <span class="auth-card__logo-icon">🦁</span>
                    <span>LORD LION</span>
                </a>
                <h1 class="auth-card__title">Crie sua conta</h1>
                <p class="auth-card__subtitle">Cadastre-se para fazer seus pedidos</p>
            </div>

            <?= $this->Form->create($customer, ['class' => 'auth-form']) ?>
                <div class="auth-form__row">
                    <div class="auth-form__group">
                        <label for="name" class="auth-form__label">Nome completo *</label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            class="auth-form__input <?= $customer->hasErrors() && $customer->getError('name') ? 'auth-form__input--error' : '' ?>" 
                            placeholder="Seu nome"
                            value="<?= h($customer->name) ?>"
                            required
                            autofocus
                        >
                        <?php if ($customer->getError('name')): ?>
                            <span class="auth-form__error"><?= h($customer->getError('name')[0] ?? '') ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="auth-form__row">
                    <div class="auth-form__group">
                        <label for="email" class="auth-form__label">E-mail *</label>
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            class="auth-form__input <?= $customer->hasErrors() && $customer->getError('email') ? 'auth-form__input--error' : '' ?>" 
                            placeholder="seu@email.com"
                            value="<?= h($customer->email) ?>"
                            required
                        >
                        <?php if ($customer->getError('email')): ?>
                            <span class="auth-form__error"><?= h($customer->getError('email')[0] ?? '') ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="auth-form__group">
                        <label for="phone" class="auth-form__label">Telefone</label>
                        <input 
                            type="tel" 
                            name="phone" 
                            id="phone" 
                            class="auth-form__input" 
                            placeholder="(11) 99999-9999"
                            value="<?= h($customer->phone) ?>"
                        >
                    </div>
                </div>

                <div class="auth-form__row">
                    <div class="auth-form__group">
                        <label for="password" class="auth-form__label">Senha *</label>
                        <div class="auth-form__password-wrapper">
                            <input 
                                type="password" 
                                name="password" 
                                id="password" 
                                class="auth-form__input <?= $customer->hasErrors() && $customer->getError('password') ? 'auth-form__input--error' : '' ?>" 
                                placeholder="Mínimo 6 caracteres"
                                required
                            >
                            <button type="button" class="auth-form__password-toggle" onclick="togglePassword('password')">
                                👁️
                            </button>
                        </div>
                        <?php if ($customer->getError('password')): ?>
                            <span class="auth-form__error"><?= h($customer->getError('password')[0] ?? '') ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="auth-form__group">
                        <label for="password_confirm" class="auth-form__label">Confirmar senha *</label>
                        <div class="auth-form__password-wrapper">
                            <input 
                                type="password" 
                                name="password_confirm" 
                                id="password_confirm" 
                                class="auth-form__input <?= $customer->hasErrors() && $customer->getError('password_confirm') ? 'auth-form__input--error' : '' ?>" 
                                placeholder="Repita a senha"
                                required
                            >
                            <button type="button" class="auth-form__password-toggle" onclick="togglePassword('password_confirm')">
                                👁️
                            </button>
                        </div>
                        <?php if ($customer->getError('password_confirm')): ?>
                            <span class="auth-form__error"><?= h($customer->getError('password_confirm')[0] ?? '') ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="auth-form__terms">
                    <label class="auth-form__checkbox-label">
                        <input type="checkbox" name="terms" class="auth-form__checkbox" required>
                        <span>Li e aceito os <a href="#">Termos de Uso</a> e <a href="#">Política de Privacidade</a></span>
                    </label>
                </div>

                <button type="submit" class="auth-form__submit">
                    Criar conta
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg>
                </button>
            <?= $this->Form->end() ?>

            <div class="auth-card__footer">
                <p>Já tem uma conta? 
                    <a href="<?= $this->Url->build('/entrar') ?>">Entrar</a>
                </p>
            </div>

            <div class="auth-card__divider">
                <span>ou</span>
            </div>

            <a href="<?= $this->Url->build('/shop') ?>" class="auth-card__back">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m12 19-7-7 7-7"></path>
                    <path d="M19 12H5"></path>
                </svg>
                Voltar para a loja
            </a>
        </div>
    </div>
</section>

<?php $this->start('scriptBottom'); ?>
<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    input.type = input.type === 'password' ? 'text' : 'password';
}

// Phone mask
document.getElementById('phone').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length > 11) value = value.slice(0, 11);
    
    if (value.length > 0) {
        if (value.length <= 2) {
            value = '(' + value;
        } else if (value.length <= 7) {
            value = '(' + value.slice(0, 2) + ') ' + value.slice(2);
        } else {
            value = '(' + value.slice(0, 2) + ') ' + value.slice(2, 7) + '-' + value.slice(7);
        }
    }
    e.target.value = value;
});
</script>
<?php $this->end(); ?>
