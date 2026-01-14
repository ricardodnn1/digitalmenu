<?php
/**
 * Shop Layout - Lord Lion Cervejaria Style
 * Modern Mobile-First Ecommerce Layout
 *
 * @var \App\View\AppView $this
 * @var array|null $shopSettings Shop settings from controller
 */

use Cake\ORM\TableRegistry;

$shopName = 'LORD LION';
$shopTagline = 'Cervejaria Artesanal';

// Load shop settings if not already available
if (!isset($shopSettings)) {
    try {
        $shopSettingsTable = TableRegistry::getTableLocator()->get('ShopSettings');
        $shopSettings = [
            'onlinePaymentEnabled' => $shopSettingsTable->isOnlinePaymentEnabled(),
            'whatsapp' => $shopSettingsTable->getWhatsAppSettings(),
            'storeName' => $shopSettingsTable->getValue('store_name', 'Lord Lion Cervejaria'),
            'minimumOrderAmount' => (float) $shopSettingsTable->getValue('minimum_order_amount', '20.00'),
            'deliveryFee' => (float) $shopSettingsTable->getValue('delivery_fee', '5.00'),
        ];
    } catch (Exception $e) {
        // Default settings if table doesn't exist yet
        $shopSettings = [
            'onlinePaymentEnabled' => false,
            'whatsapp' => [
                'number' => '5511999999999',
                'header' => 'Olá! Gostaria de fazer um pedido:',
                'footer' => 'Aguardo confirmação. Obrigado!',
            ],
            'storeName' => 'Lord Lion Cervejaria',
            'minimumOrderAmount' => 20.00,
            'deliveryFee' => 5.00,
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $shopName ?> - <?= $shopTagline ?>. Cervejas artesanais selecionadas para você.">
    <meta name="theme-color" content="#1a1a2e">
    
    <title><?= $this->fetch('title') ? $this->fetch('title') . ' | ' : '' ?><?= $shopName ?> - <?= $shopTagline ?></title>
    
    <?= $this->Html->meta('icon') ?>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;500;600;700&family=Oswald:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <?= $this->Html->css(['shop']) ?>
    
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body>
    <div class="main-layout">
        <!-- Top Navigation -->
        <nav class="top-nav">
            <div class="container top-nav__container">
                <!-- Logo -->
                <div class="top-nav__logo">
                    <a href="<?= $this->Url->build('/shop') ?>">
                        <span class="top-nav__logo-icon">🦁</span>
                        <span><?= $shopName ?></span>
                    </a>
                </div>
                
                <!-- Search Bar (Desktop) -->
                <div class="top-nav__search">
                    <div class="top-nav__search-wrapper">
                        <svg class="top-nav__search-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.35-4.35"></path>
                        </svg>
                        <input type="text" class="top-nav__search-input" placeholder="Buscar cervejas, kits, acessórios..." aria-label="Buscar produtos">
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="top-nav__actions">
                    <!-- Search Toggle (Mobile) -->
                    <button class="top-nav__btn top-nav__btn--search" aria-label="Buscar">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.35-4.35"></path>
                        </svg>
                    </button>
                    
                    <!-- User Account (only visible when online payment is enabled) -->
                    <?php 
                    $onlinePaymentEnabled = $shopSettings['onlinePaymentEnabled'] ?? false;
                    $loggedCustomer = $this->request->getSession()->read('Customer');
                    ?>
                    <?php if ($onlinePaymentEnabled): ?>
                        <?php if ($loggedCustomer): ?>
                        <!-- Logged in user dropdown -->
                        <div class="top-nav__user-menu">
                            <button class="top-nav__btn" aria-label="Minha conta">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </button>
                            <div class="top-nav__user-dropdown">
                                <a href="<?= $this->Url->build('/minha-conta') ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    Olá, <?= h($loggedCustomer['name'] ? explode(' ', $loggedCustomer['name'])[0] : 'Cliente') ?>
                                </a>
                                <a href="<?= $this->Url->build('/minha-conta') ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                    Meu Perfil
                                </a>
                                <a href="<?= $this->Url->build('/sair') ?>" class="logout">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                        <polyline points="16 17 21 12 16 7"></polyline>
                                        <line x1="21" y1="12" x2="9" y2="12"></line>
                                    </svg>
                                    Sair
                                </a>
                            </div>
                        </div>
                        <?php else: ?>
                        <!-- Not logged in - show login button -->
                        <a href="<?= $this->Url->build('/entrar') ?>" class="top-nav__btn" aria-label="Entrar">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </a>
                        <?php endif; ?>
                    <?php endif; ?>
                    
                    <!-- Cart -->
                    <button class="top-nav__btn" aria-label="Carrinho" id="cart-toggle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="8" cy="21" r="1"></circle>
                            <circle cx="19" cy="21" r="1"></circle>
                            <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path>
                        </svg>
                        <span class="top-nav__cart-badge" id="cart-count">3</span>
                    </button>
                </div>
            </div>
        </nav>
        
        <!-- Store Status Bar -->
        <?php
        // Lógica de horário de funcionamento
        $timezone = new DateTimeZone('America/Sao_Paulo');
        $now = new DateTime('now', $timezone);
        $currentHour = (int) $now->format('H');
        $currentDay = (int) $now->format('w'); // 0 = domingo, 6 = sábado
        
        // Horário de funcionamento: Seg-Sex 10h-22h, Sáb 10h-23h, Dom 12h-20h
        $isOpen = false;
        $openTime = '';
        $closeTime = '';
        
        if ($currentDay >= 1 && $currentDay <= 5) { // Segunda a Sexta
            $openTime = '10:00';
            $closeTime = '22:00';
            $isOpen = ($currentHour >= 10 && $currentHour < 22);
        } elseif ($currentDay == 6) { // Sábado
            $openTime = '10:00';
            $closeTime = '23:00';
            $isOpen = ($currentHour >= 10 && $currentHour < 23);
        } else { // Domingo
            $openTime = '12:00';
            $closeTime = '20:00';
            $isOpen = ($currentHour >= 12 && $currentHour < 20);
        }
        ?>
        <div class="store-status <?= $isOpen ? 'store-status--open' : 'store-status--closed' ?>">
            <div class="store-status__container">
                <span class="store-status__indicator"></span>
                <span class="store-status__badge"><?= $isOpen ? 'Aberto' : 'Fechado' ?></span>
                <span class="store-status__text">
                    <?php if ($isOpen): ?>
                        Estamos atendendo agora!
                    <?php else: ?>
                        Abrimos às <strong><?= $openTime ?></strong>
                    <?php endif; ?>
                </span>
                <span class="store-status__hours">• Hoje: <?= $openTime ?> - <?= $closeTime ?></span>
            </div>
        </div>
        
        <!-- Payment Mode Banner -->
        <?php $onlinePaymentEnabled = $shopSettings['onlinePaymentEnabled'] ?? false; ?>
        <div class="payment-mode-banner <?= $onlinePaymentEnabled ? 'payment-mode-banner--online' : 'payment-mode-banner--whatsapp' ?>">
            <div class="payment-mode-banner__container">
                <?php if ($onlinePaymentEnabled): ?>
                    <span class="payment-mode-banner__icon">💳</span>
                    <span class="payment-mode-banner__text">
                        <strong>Pagamento Online</strong> • Pague com cartão, PIX ou boleto
                    </span>
                    <span class="payment-mode-banner__badge">Checkout Seguro</span>
                <?php else: ?>
                    <span class="payment-mode-banner__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                    </span>
                    <span class="payment-mode-banner__text">
                        <strong>Pedido via WhatsApp</strong> • Envie seu pedido e pague na entrega
                    </span>
                    <span class="payment-mode-banner__badge">Atendimento Direto</span>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Categories Bar -->
        <div class="categories-bar">
            <div class="categories-bar__container">
                <ul class="categories-bar__list">
                    <li class="categories-bar__item">
                        <a href="#" class="categories-bar__link categories-bar__link--active">
                            <span class="categories-bar__icon">🍺</span>
                            <span>Todos</span>
                        </a>
                    </li>
                    <li class="categories-bar__item">
                        <a href="#" class="categories-bar__link">
                            <span class="categories-bar__icon">🌾</span>
                            <span>Pilsen</span>
                        </a>
                    </li>
                    <li class="categories-bar__item">
                        <a href="#" class="categories-bar__link">
                            <span class="categories-bar__icon">🍻</span>
                            <span>IPA</span>
                        </a>
                    </li>
                    <li class="categories-bar__item">
                        <a href="#" class="categories-bar__link">
                            <span class="categories-bar__icon">🥃</span>
                            <span>Stout</span>
                        </a>
                    </li>
                    <li class="categories-bar__item">
                        <a href="#" class="categories-bar__link">
                            <span class="categories-bar__icon">🍯</span>
                            <span>Weiss</span>
                        </a>
                    </li>
                    <li class="categories-bar__item">
                        <a href="#" class="categories-bar__link">
                            <span class="categories-bar__icon">🎁</span>
                            <span>Kits</span>
                        </a>
                    </li>
                    <li class="categories-bar__item">
                        <a href="#" class="categories-bar__link">
                            <span class="categories-bar__icon">🍷</span>
                            <span>Copos</span>
                        </a>
                    </li>
                    <li class="categories-bar__item">
                        <a href="#" class="categories-bar__link">
                            <span class="categories-bar__icon">🔥</span>
                            <span>Promoções</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Main Content -->
        <main class="main-content">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </main>
        
        <!-- Mobile Sticky Cart Bar -->
        <div class="mobile-cart-bar <?= $onlinePaymentEnabled ? 'mobile-cart-bar--online' : 'mobile-cart-bar--whatsapp' ?>" id="mobile-cart-bar" style="transform: translateY(100%);">
            <div class="mobile-cart-bar__info">
                <span class="mobile-cart-bar__items">0 itens no carrinho</span>
                <span class="mobile-cart-bar__total">R$ 0,00</span>
            </div>
            <a href="#" class="mobile-cart-bar__btn" id="checkout-btn">
                <?php if ($onlinePaymentEnabled): ?>
                <!-- Online Payment Mode -->
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                    <line x1="1" y1="10" x2="23" y2="10"></line>
                </svg>
                <span>Pagar Agora</span>
                <?php else: ?>
                <!-- WhatsApp Mode -->
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                <span>Enviar pelo WhatsApp</span>
                <?php endif; ?>
            </a>
        </div>
        
        <!-- Footer -->
        <footer class="footer">
            <div class="container footer__container">
                <!-- Brand Section -->
                <div class="footer__brand">
                    <a href="<?= $this->Url->build('/shop') ?>" class="footer__logo">
                        <span class="footer__logo-icon">🦁</span>
                        <span><?= $shopName ?></span>
                    </a>
                    <p class="footer__tagline"><?= $shopTagline ?> desde 2018. Cervejas artesanais com alma e tradição.</p>
                    
                    <!-- Social Links -->
                    <div class="footer__social">
                        <a href="#" class="footer__social-link" aria-label="Instagram" title="Instagram">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                            </svg>
                        </a>
                        <a href="#" class="footer__social-link" aria-label="Facebook" title="Facebook">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                            </svg>
                        </a>
                        <a href="https://wa.me/5511999999999" class="footer__social-link" aria-label="WhatsApp" title="WhatsApp">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div class="footer__section">
                    <h4 class="footer__section-title">Navegação</h4>
                    <ul class="footer__links">
                        <li><a href="#" class="footer__link">Início</a></li>
                        <li><a href="#" class="footer__link">Produtos</a></li>
                        <li><a href="#" class="footer__link">Sobre Nós</a></li>
                        <li><a href="#" class="footer__link">Blog</a></li>
                        <li><a href="#" class="footer__link">Contato</a></li>
                    </ul>
                </div>
                
                <!-- Categories -->
                <div class="footer__section">
                    <h4 class="footer__section-title">Categorias</h4>
                    <ul class="footer__links">
                        <li><a href="#" class="footer__link">Cervejas Pilsen</a></li>
                        <li><a href="#" class="footer__link">Cervejas IPA</a></li>
                        <li><a href="#" class="footer__link">Cervejas Stout</a></li>
                        <li><a href="#" class="footer__link">Kits e Presentes</a></li>
                        <li><a href="#" class="footer__link">Acessórios</a></li>
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div class="footer__section">
                    <h4 class="footer__section-title">Contato</h4>
                    <div class="footer__contact-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <span>Rua das Cervejas, 123<br>São Paulo - SP</span>
                    </div>
                    <div class="footer__contact-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        <span>(11) 99999-9999</span>
                    </div>
                    <div class="footer__contact-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        <span>contato@lordlion.com.br</span>
                    </div>
                    <a href="https://wa.me/5511999999999" class="footer__whatsapp-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        Falar no WhatsApp
                    </a>
                </div>
            </div>
            
            <!-- Footer Bottom -->
            <div class="footer__bottom">
                <p class="footer__copyright">&copy; <?= date('Y') ?> <?= $shopName ?>. Todos os direitos reservados.</p>
                <div class="footer__policies">
                    <a href="#" class="footer__policy-link">Política de Privacidade</a>
                    <a href="#" class="footer__policy-link">Termos de Uso</a>
                    <a href="#" class="footer__policy-link">Trocas e Devoluções</a>
                    <a href="#" class="footer__policy-link">Entregas</a>
                </div>
            </div>
        </footer>
    </div>
    
    <?= $this->fetch('script') ?>
    <?= $this->fetch('scriptBottom') ?>
</body>
</html>
