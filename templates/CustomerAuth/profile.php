<?php
/**
 * Customer Profile Page
 *
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer $customer
 */

$this->assign('title', 'Meu Perfil');
?>

<section class="profile-page">
    <div class="container">
        <div class="profile-header">
            <a href="<?= $this->Url->build('/shop') ?>" class="profile-header__back">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m12 19-7-7 7-7"></path>
                    <path d="M19 12H5"></path>
                </svg>
                Voltar à loja
            </a>
            <h1 class="profile-header__title">Meu Perfil</h1>
            <a href="<?= $this->Url->build('/sair') ?>" class="profile-header__logout">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
                Sair
            </a>
        </div>

        <div class="profile-grid">
            <!-- Profile Info Card -->
            <div class="profile-card">
                <div class="profile-card__header">
                    <div class="profile-card__avatar">
                        <?= strtoupper(substr($customer->name, 0, 2)) ?>
                    </div>
                    <div class="profile-card__info">
                        <h2><?= h($customer->name) ?></h2>
                        <p><?= h($customer->email) ?></p>
                    </div>
                </div>

                <?= $this->Form->create($customer, ['class' => 'profile-form']) ?>
                    <h3 class="profile-form__section-title">Dados Pessoais</h3>
                    
                    <div class="profile-form__row">
                        <div class="profile-form__group">
                            <label for="name" class="profile-form__label">Nome completo</label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                class="profile-form__input" 
                                value="<?= h($customer->name) ?>"
                                required
                            >
                        </div>
                    </div>

                    <div class="profile-form__row">
                        <div class="profile-form__group">
                            <label for="email" class="profile-form__label">E-mail</label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                class="profile-form__input" 
                                value="<?= h($customer->email) ?>"
                                required
                            >
                        </div>

                        <div class="profile-form__group">
                            <label for="phone" class="profile-form__label">Telefone</label>
                            <input 
                                type="tel" 
                                name="phone" 
                                id="phone" 
                                class="profile-form__input" 
                                value="<?= h($customer->phone) ?>"
                                placeholder="(11) 99999-9999"
                            >
                        </div>
                    </div>

                    <div class="profile-form__row">
                        <div class="profile-form__group">
                            <label for="cpf" class="profile-form__label">CPF</label>
                            <input 
                                type="text" 
                                name="cpf" 
                                id="cpf" 
                                class="profile-form__input" 
                                value="<?= h($customer->cpf) ?>"
                                placeholder="000.000.000-00"
                            >
                        </div>
                    </div>

                    <h3 class="profile-form__section-title">Endereço Principal</h3>

                    <div class="profile-form__row">
                        <div class="profile-form__group profile-form__group--small">
                            <label for="address_zipcode" class="profile-form__label">CEP</label>
                            <input 
                                type="text" 
                                name="address_zipcode" 
                                id="address_zipcode" 
                                class="profile-form__input" 
                                value="<?= h($customer->address_zipcode) ?>"
                                placeholder="00000-000"
                            >
                        </div>

                        <div class="profile-form__group profile-form__group--large">
                            <label for="address_street" class="profile-form__label">Rua</label>
                            <input 
                                type="text" 
                                name="address_street" 
                                id="address_street" 
                                class="profile-form__input" 
                                value="<?= h($customer->address_street) ?>"
                                placeholder="Nome da rua"
                            >
                        </div>
                    </div>

                    <div class="profile-form__row">
                        <div class="profile-form__group profile-form__group--small">
                            <label for="address_number" class="profile-form__label">Número</label>
                            <input 
                                type="text" 
                                name="address_number" 
                                id="address_number" 
                                class="profile-form__input" 
                                value="<?= h($customer->address_number) ?>"
                                placeholder="123"
                            >
                        </div>

                        <div class="profile-form__group">
                            <label for="address_complement" class="profile-form__label">Complemento</label>
                            <input 
                                type="text" 
                                name="address_complement" 
                                id="address_complement" 
                                class="profile-form__input" 
                                value="<?= h($customer->address_complement) ?>"
                                placeholder="Apto, bloco..."
                            >
                        </div>

                        <div class="profile-form__group">
                            <label for="address_neighborhood" class="profile-form__label">Bairro</label>
                            <input 
                                type="text" 
                                name="address_neighborhood" 
                                id="address_neighborhood" 
                                class="profile-form__input" 
                                value="<?= h($customer->address_neighborhood) ?>"
                                placeholder="Bairro"
                            >
                        </div>
                    </div>

                    <div class="profile-form__row">
                        <div class="profile-form__group profile-form__group--large">
                            <label for="address_city" class="profile-form__label">Cidade</label>
                            <input 
                                type="text" 
                                name="address_city" 
                                id="address_city" 
                                class="profile-form__input" 
                                value="<?= h($customer->address_city) ?>"
                                placeholder="Cidade"
                            >
                        </div>

                        <div class="profile-form__group profile-form__group--small">
                            <label for="address_state" class="profile-form__label">Estado</label>
                            <select name="address_state" id="address_state" class="profile-form__input">
                                <option value="">UF</option>
                                <?php
                                $states = ['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'];
                                foreach ($states as $state):
                                ?>
                                <option value="<?= $state ?>" <?= $customer->address_state === $state ? 'selected' : '' ?>><?= $state ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <h3 class="profile-form__section-title">Alterar Senha</h3>
                    <p class="profile-form__hint">Deixe em branco para manter a senha atual</p>

                    <div class="profile-form__row">
                        <div class="profile-form__group">
                            <label for="password" class="profile-form__label">Nova senha</label>
                            <input 
                                type="password" 
                                name="password" 
                                id="password" 
                                class="profile-form__input" 
                                placeholder="Nova senha (opcional)"
                            >
                        </div>
                    </div>

                    <div class="profile-form__actions">
                        <button type="submit" class="profile-form__submit">
                            💾 Salvar Alterações
                        </button>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</section>

<?php $this->start('scriptBottom'); ?>
<script>
// Phone mask
document.getElementById('phone')?.addEventListener('input', function(e) {
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

// CPF mask
document.getElementById('cpf')?.addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length > 11) value = value.slice(0, 11);
    
    if (value.length > 0) {
        if (value.length <= 3) {
            // keep as is
        } else if (value.length <= 6) {
            value = value.slice(0, 3) + '.' + value.slice(3);
        } else if (value.length <= 9) {
            value = value.slice(0, 3) + '.' + value.slice(3, 6) + '.' + value.slice(6);
        } else {
            value = value.slice(0, 3) + '.' + value.slice(3, 6) + '.' + value.slice(6, 9) + '-' + value.slice(9);
        }
    }
    e.target.value = value;
});

// CEP mask and autocomplete
document.getElementById('address_zipcode')?.addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length > 8) value = value.slice(0, 8);
    
    if (value.length > 5) {
        value = value.slice(0, 5) + '-' + value.slice(5);
    }
    e.target.value = value;
    
    // Autocomplete address
    if (value.replace('-', '').length === 8) {
        fetch(`https://viacep.com.br/ws/${value.replace('-', '')}/json/`)
            .then(response => response.json())
            .then(data => {
                if (!data.erro) {
                    document.getElementById('address_street').value = data.logradouro || '';
                    document.getElementById('address_neighborhood').value = data.bairro || '';
                    document.getElementById('address_city').value = data.localidade || '';
                    document.getElementById('address_state').value = data.uf || '';
                }
            })
            .catch(() => {});
    }
});
</script>
<?php $this->end(); ?>
