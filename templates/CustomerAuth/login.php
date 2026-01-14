<?php
/**
 * Customer Login Page
 *
 * @var \App\View\AppView $this
 */

$this->assign('title', 'Entrar');
?>

<section class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-card__header">
                <a href="<?= $this->Url->build('/shop') ?>" class="auth-card__logo">
                    <span class="auth-card__logo-icon">🦁</span>
                    <span>LORD LION</span>
                </a>
                <h1 class="auth-card__title">Bem-vindo de volta!</h1>
                <p class="auth-card__subtitle">Entre na sua conta para continuar</p>
            </div>

            <?= $this->Form->create(null, ['class' => 'auth-form']) ?>
                <div class="auth-form__group">
                    <label for="email" class="auth-form__label">E-mail</label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        class="auth-form__input" 
                        placeholder="seu@email.com"
                        required
                        autofocus
                    >
                </div>

                <div class="auth-form__group">
                    <label for="password" class="auth-form__label">
                        Senha
                        <a href="#" class="auth-form__forgot">Esqueceu?</a>
                    </label>
                    <div class="auth-form__password-wrapper">
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            class="auth-form__input" 
                            placeholder="••••••••"
                            required
                        >
                        <button type="button" class="auth-form__password-toggle" onclick="togglePassword('password')">
                            👁️
                        </button>
                    </div>
                </div>

                <div class="auth-form__remember">
                    <label class="auth-form__checkbox-label">
                        <input type="checkbox" name="remember" class="auth-form__checkbox">
                        <span>Manter conectado</span>
                    </label>
                </div>

                <button type="submit" class="auth-form__submit">
                    Entrar
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg>
                </button>
            <?= $this->Form->end() ?>

            <div class="auth-card__footer">
                <p>Não tem uma conta? 
                    <a href="<?= $this->Url->build('/cadastrar') ?>">Cadastre-se</a>
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
</script>
<?php $this->end(); ?>
