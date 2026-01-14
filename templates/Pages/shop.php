<?php
/**
 * Shop Product Listing Page
 * Lord Lion Cervejaria - Ecommerce Style
 *
 * @var \App\View\AppView $this
 * @var array $shopSettings Shop configuration settings
 */

$this->setLayout('shop');
$this->assign('title', 'Loja - Cervejas Artesanais');

// Get shop settings with defaults
$shopSettings = $shopSettings ?? [
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

// Mock products data
$products = [
    [
        'id' => 1,
        'name' => 'Lord Lion Imperial IPA',
        'category' => 'IPA',
        'price' => 29.90,
        'old_price' => null,
        'badge' => 'bestseller',
        'rating' => 5,
        'reviews' => 128,
        'image' => 'https://images.unsplash.com/photo-1608270586620-248524c67de9?w=400&h=400&fit=crop',
        'description' => 'Uma IPA robusta com notas cítricas e amargor equilibrado. Ideal para os amantes de cervejas encorpadas.'
    ],
    [
        'id' => 2,
        'name' => 'Golden Pride Pilsen',
        'category' => 'Pilsen',
        'price' => 18.90,
        'old_price' => 24.90,
        'badge' => 'sale',
        'rating' => 4,
        'reviews' => 89,
        'image' => 'https://images.unsplash.com/photo-1535958636474-b021ee887b13?w=400&h=400&fit=crop',
        'description' => 'Pilsen leve e refrescante, perfeita para qualquer ocasião. Sabor suave e final seco.'
    ],
    [
        'id' => 3,
        'name' => 'Dark Roar Stout',
        'category' => 'Stout',
        'price' => 34.90,
        'old_price' => null,
        'badge' => 'new',
        'rating' => 5,
        'reviews' => 45,
        'image' => 'https://images.unsplash.com/photo-1618183479302-1e0aa382c36b?w=400&h=400&fit=crop',
        'description' => 'Stout cremosa com notas de chocolate e café. Uma experiência sensorial única.'
    ],
    [
        'id' => 4,
        'name' => 'Sunset Weiss',
        'category' => 'Weiss',
        'price' => 22.90,
        'old_price' => null,
        'badge' => null,
        'rating' => 4,
        'reviews' => 67,
        'image' => 'https://images.unsplash.com/photo-1558642452-9d2a7deb7f62?w=400&h=400&fit=crop',
        'description' => 'Cerveja de trigo refrescante com notas de banana e cravo. Perfeita para o verão.'
    ],
    [
        'id' => 5,
        'name' => 'Hop Hunter Session IPA',
        'category' => 'IPA',
        'price' => 24.90,
        'old_price' => 29.90,
        'badge' => 'sale',
        'rating' => 4,
        'reviews' => 103,
        'image' => 'https://images.unsplash.com/photo-1571613316887-6f8d5cbf7ef7?w=400&h=400&fit=crop',
        'description' => 'Session IPA leve mas aromática. Ideal para sessões prolongadas com os amigos.'
    ],
    [
        'id' => 6,
        'name' => 'Midnight Velvet Porter',
        'category' => 'Porter',
        'price' => 32.90,
        'old_price' => null,
        'badge' => 'new',
        'rating' => 5,
        'reviews' => 34,
        'image' => 'https://images.unsplash.com/photo-1532634922-8fe0b757fb13?w=400&h=400&fit=crop',
        'description' => 'Porter aveludada com toques de caramelo e malte torrado. Complexa e envolvente.'
    ],
    [
        'id' => 7,
        'name' => 'Kit Degustação Premium',
        'category' => 'Kits',
        'price' => 149.90,
        'old_price' => 189.90,
        'badge' => 'sale',
        'rating' => 5,
        'reviews' => 256,
        'image' => 'https://images.unsplash.com/photo-1584225064785-c62a8b43d148?w=400&h=400&fit=crop',
        'description' => '6 cervejas selecionadas + copo exclusivo Lord Lion. O presente perfeito.'
    ],
    [
        'id' => 8,
        'name' => 'Tropical Haze NEIPA',
        'category' => 'IPA',
        'price' => 28.90,
        'old_price' => null,
        'badge' => 'bestseller',
        'rating' => 5,
        'reviews' => 178,
        'image' => 'https://images.unsplash.com/photo-1566633806327-68e152aaf26d?w=400&h=400&fit=crop',
        'description' => 'NEIPA turva e suculenta com notas de frutas tropicais. Explosão de sabor.'
    ],
    [
        'id' => 9,
        'name' => 'Classic Amber Lager',
        'category' => 'Lager',
        'price' => 19.90,
        'old_price' => null,
        'badge' => null,
        'rating' => 4,
        'reviews' => 92,
        'image' => 'https://images.unsplash.com/photo-1600788886242-5c96aabe3757?w=400&h=400&fit=crop',
        'description' => 'Lager âmbar com corpo médio e notas de caramelo. Equilibrada e versátil.'
    ],
];

// Helper function to render stars
function renderStars($rating) {
    $html = '';
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $rating) {
            $html .= '★';
        } else {
            $html .= '☆';
        }
    }
    return $html;
}

// Helper function to format price in BRL
function formatPrice($price) {
    return 'R$ ' . number_format($price, 2, ',', '.');
}
?>

<!-- Hero Section -->
<section class="hero">
    <div class="container hero__container">
        <div class="hero__content">
            <span class="hero__badge">🔥 Novidades</span>
            <h1 class="hero__title">
                Cervejas <span>Artesanais</span><br>
                de Verdade
            </h1>
            <p class="hero__description">
                Descubra o sabor único das nossas cervejas produzidas com ingredientes selecionados e muito amor pela arte cervejeira.
            </p>
            <a href="#produtos" class="hero__cta">
                Ver Produtos
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12h14"></path>
                    <path d="m12 5 7 7-7 7"></path>
                </svg>
            </a>
        </div>
        <div class="hero__image">
            <img src="https://images.unsplash.com/photo-1558642452-9d2a7deb7f62?w=500&h=600&fit=crop" alt="Cervejas Lord Lion" loading="lazy">
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="container" id="produtos">
    <div class="shop-grid">
        <!-- Filters Sidebar -->
        <aside class="filters" id="filters-sidebar">
            <div class="filters__header">
                <h3 class="filters__title">Filtros</h3>
                <button class="filters__close" id="filters-close" aria-label="Fechar filtros">✕</button>
            </div>
            
            <!-- Search Filter -->
            <div class="filters__section">
                <h4 class="filters__section-title">Buscar</h4>
                <div class="filters__search">
                    <input type="text" class="filters__search-input" id="filter-search" placeholder="Nome do produto...">
                </div>
            </div>
            
            <!-- Categories Filter -->
            <div class="filters__section">
                <h4 class="filters__section-title">Categorias</h4>
                <ul class="filters__list">
                    <?php
                    // Get unique categories from products
                    $categories = array_unique(array_column($products, 'category'));
                    $categoryCounts = array_count_values(array_column($products, 'category'));
                    foreach ($categories as $category):
                    $catId = strtolower(str_replace(' ', '-', $category));
                    ?>
                    <li class="filters__item">
                        <input type="checkbox" class="filters__checkbox filters__category-checkbox" id="cat-<?= $catId ?>" value="<?= strtolower($category) ?>" checked>
                        <label class="filters__label" for="cat-<?= $catId ?>"><?= h($category) ?> (<?= $categoryCounts[$category] ?? 0 ?>)</label>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            
            <!-- Price Range Filter -->
            <div class="filters__section">
                <h4 class="filters__section-title">Faixa de Preço</h4>
                <div class="filters__price-range">
                    <input type="range" class="filters__price-slider" min="0" max="200" value="200" id="price-range">
                    <div class="filters__price-values">
                        <span>R$ 0</span>
                        <span id="price-value">R$ 200</span>
                    </div>
                </div>
            </div>
            
            <!-- Tags Filter -->
            <div class="filters__section">
                <h4 class="filters__section-title">Tags Populares</h4>
                <div class="filters__tags">
                    <button class="filters__tag" data-badge="sale">🔥 Promoção</button>
                    <button class="filters__tag" data-badge="new">✨ Novidades</button>
                    <button class="filters__tag" data-badge="bestseller">⭐ Mais Vendidos</button>
                </div>
            </div>
            
            <button class="filters__apply-btn" id="filters-apply">Aplicar Filtros</button>
        </aside>
        
        <!-- Products Grid Section -->
        <div class="products-section">
            <!-- Mobile Filter Toggle -->
            <div class="filter-toggle">
                <button class="filter-toggle__btn" id="filter-toggle-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                    </svg>
                    Filtrar
                </button>
                <div class="filter-toggle__sort">
                    <select aria-label="Ordenar por">
                        <option value="popular">Mais Populares</option>
                        <option value="newest">Mais Recentes</option>
                        <option value="price-low">Menor Preço</option>
                        <option value="price-high">Maior Preço</option>
                        <option value="rating">Melhor Avaliados</option>
                    </select>
                </div>
            </div>
            
            <!-- Header -->
            <div class="products-section__header">
                <div>
                    <h2 class="products-section__title">Nossos Produtos</h2>
                    <span class="products-section__count"><?= count($products) ?> produtos encontrados</span>
                </div>
                <div class="products-section__sort">
                    <label for="sort-desktop">Ordenar por:</label>
                    <select id="sort-desktop">
                        <option value="popular">Mais Populares</option>
                        <option value="newest">Mais Recentes</option>
                        <option value="price-low">Menor Preço</option>
                        <option value="price-high">Maior Preço</option>
                        <option value="rating">Melhor Avaliados</option>
                    </select>
                </div>
            </div>
            
            <!-- Products Grid -->
            <div class="products-grid" id="products-grid">
                <?php foreach ($products as $index => $product): ?>
                <article class="product-card animate-fade-in animate-delay-<?= ($index % 6) + 1 ?>" 
                         data-product-id="<?= $product['id'] ?>"
                         data-category="<?= strtolower(h($product['category'])) ?>"
                         data-name="<?= strtolower(h($product['name'])) ?>"
                         data-price="<?= $product['price'] ?>"
                         data-badge="<?= h($product['badge'] ?? '') ?>">
                    <!-- Badge -->
                    <?php if ($product['badge']): ?>
                    <span class="product-card__badge product-card__badge--<?= $product['badge'] ?>">
                        <?php
                        switch ($product['badge']) {
                            case 'sale':
                                echo '🔥 Oferta';
                                break;
                            case 'new':
                                echo '✨ Novo';
                                break;
                            case 'bestseller':
                                echo '⭐ Mais Vendido';
                                break;
                        }
                        ?>
                    </span>
                    <?php endif; ?>
                    
                    <!-- Wishlist Button -->
                    <button class="product-card__wishlist" aria-label="Adicionar aos favoritos">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                        </svg>
                    </button>
                    
                    <!-- Image -->
                    <div class="product-card__image-wrapper">
                        <img 
                            src="<?= h($product['image']) ?>" 
                            alt="<?= h($product['name']) ?>" 
                            class="product-card__image"
                            loading="lazy"
                        >
                        <button class="product-card__quick-view" data-product-id="<?= $product['id'] ?>">
                            👁️ Visualização Rápida
                        </button>
                    </div>
                    
                    <!-- Content -->
                    <div class="product-card__content">
                        <span class="product-card__category"><?= h($product['category']) ?></span>
                        <h3 class="product-card__name">
                            <a href="#"><?= h($product['name']) ?></a>
                        </h3>
                        
                        <!-- Rating -->
                        <div class="product-card__rating">
                            <span class="product-card__stars"><?= renderStars($product['rating']) ?></span>
                            <span class="product-card__rating-count">(<?= $product['reviews'] ?>)</span>
                        </div>
                        
                        <!-- Price & Add to Cart -->
                        <div class="product-card__price-row">
                            <div class="product-card__price">
                                <span class="product-card__price-current"><?= formatPrice($product['price']) ?></span>
                                <?php if ($product['old_price']): ?>
                                <span class="product-card__price-old"><?= formatPrice($product['old_price']) ?></span>
                                <?php endif; ?>
                            </div>
                            <button class="product-card__add-btn" aria-label="Adicionar ao carrinho" data-product-id="<?= $product['id'] ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </button>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
            
            <!-- Load More -->
            <div class="load-more">
                <button class="load-more__btn">
                    Carregar Mais Produtos
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 12a9 9 0 1 1-6.219-8.56"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Quick View Modal -->
<div class="quick-view-overlay" id="quick-view-overlay">
    <div class="quick-view-modal">
        <button class="quick-view-modal__close" id="quick-view-close" aria-label="Fechar">✕</button>
        <div class="quick-view-modal__image">
            <img src="" alt="" id="quick-view-image">
        </div>
        <div class="quick-view-modal__content">
            <span class="quick-view-modal__category" id="quick-view-category"></span>
            <h2 class="quick-view-modal__title" id="quick-view-title"></h2>
            <p class="quick-view-modal__price" id="quick-view-price"></p>
            <p class="quick-view-modal__description" id="quick-view-description"></p>
            
            <div class="quick-view-modal__quantity">
                <span class="quick-view-modal__quantity-label">Quantidade:</span>
                <div class="quick-view-modal__quantity-control">
                    <button class="quick-view-modal__quantity-btn" id="qty-decrease">−</button>
                    <span class="quick-view-modal__quantity-value" id="qty-value">1</span>
                    <button class="quick-view-modal__quantity-btn" id="qty-increase">+</button>
                </div>
            </div>
            
            <button class="quick-view-modal__add-btn" id="quick-view-add">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="8" cy="21" r="1"></circle>
                    <circle cx="19" cy="21" r="1"></circle>
                    <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path>
                </svg>
                Adicionar ao Carrinho
            </button>
        </div>
    </div>
</div>

<?php $this->start('scriptBottom'); ?>
<script>
// ============================================
// SHOP CONFIGURATION
// ============================================
const shopConfig = {
    onlinePaymentEnabled: <?= json_encode($shopSettings['onlinePaymentEnabled']) ?>,
    whatsapp: <?= json_encode($shopSettings['whatsapp']) ?>,
    storeName: <?= json_encode($shopSettings['storeName']) ?>,
    minimumOrderAmount: <?= json_encode($shopSettings['minimumOrderAmount']) ?>,
    deliveryFee: <?= json_encode($shopSettings['deliveryFee']) ?>
};

// Product data for quick view
const productsData = <?= json_encode($products) ?>;

// ============================================
// CART SYSTEM
// ============================================
class ShoppingCart {
    constructor() {
        this.items = [];
        this.loadFromStorage();
    }

    loadFromStorage() {
        try {
            const saved = localStorage.getItem('lordlion_cart');
            if (saved) {
                this.items = JSON.parse(saved);
            }
        } catch (e) {
            this.items = [];
        }
        this.updateUI();
    }

    saveToStorage() {
        localStorage.setItem('lordlion_cart', JSON.stringify(this.items));
    }

    addItem(product, quantity = 1) {
        const existingItem = this.items.find(item => item.id === product.id);
        
        if (existingItem) {
            existingItem.quantity += quantity;
        } else {
            this.items.push({
                id: product.id,
                name: product.name,
                price: product.price,
                image: product.image,
                quantity: quantity
            });
        }
        
        this.saveToStorage();
        this.updateUI();
        this.showNotification(`${product.name} adicionado ao carrinho!`);
    }

    removeItem(productId) {
        this.items = this.items.filter(item => item.id !== productId);
        this.saveToStorage();
        this.updateUI();
    }

    updateQuantity(productId, quantity) {
        const item = this.items.find(item => item.id === productId);
        if (item) {
            item.quantity = Math.max(1, quantity);
            this.saveToStorage();
            this.updateUI();
        }
    }

    clear() {
        this.items = [];
        this.saveToStorage();
        this.updateUI();
    }

    getTotal() {
        return this.items.reduce((total, item) => total + (item.price * item.quantity), 0);
    }

    getItemCount() {
        return this.items.reduce((count, item) => count + item.quantity, 0);
    }

    updateUI() {
        const count = this.getItemCount();
        const total = this.getTotal();
        
        // Update cart badge
        const cartCount = document.getElementById('cart-count');
        if (cartCount) {
            cartCount.textContent = count;
            cartCount.style.display = count > 0 ? 'flex' : 'none';
        }
        
        // Update mobile cart bar
        const mobileCartBar = document.getElementById('mobile-cart-bar');
        if (mobileCartBar) {
            const itemsText = mobileCartBar.querySelector('.mobile-cart-bar__items');
            const totalText = mobileCartBar.querySelector('.mobile-cart-bar__total');
            
            if (itemsText) itemsText.textContent = `${count} ${count === 1 ? 'item' : 'itens'} no carrinho`;
            if (totalText) totalText.textContent = formatPrice(total);
            
            // Show/hide based on items
            mobileCartBar.style.transform = count > 0 ? 'translateY(0)' : 'translateY(100%)';
        }
    }

    showNotification(message) {
        // Remove existing notification
        const existing = document.querySelector('.cart-notification');
        if (existing) existing.remove();
        
        const notification = document.createElement('div');
        notification.className = 'cart-notification';
        notification.innerHTML = `
            <span class="cart-notification__icon">✓</span>
            <span class="cart-notification__text">${message}</span>
        `;
        document.body.appendChild(notification);
        
        setTimeout(() => notification.classList.add('show'), 10);
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 2500);
    }

    // Generate WhatsApp message
    generateWhatsAppMessage() {
        if (this.items.length === 0) return '';
        
        let message = shopConfig.whatsapp.header + '\n\n';
        
        this.items.forEach(item => {
            const subtotal = item.price * item.quantity;
            message += `📦 ${item.quantity}x ${item.name} - ${formatPrice(subtotal)}\n`;
        });
        
        message += '\n─────────────\n';
        message += `💰 *Subtotal: ${formatPrice(this.getTotal())}*\n`;
        
        if (shopConfig.deliveryFee > 0) {
            message += `🚚 Taxa de entrega: ${formatPrice(shopConfig.deliveryFee)}\n`;
            message += `💵 *Total: ${formatPrice(this.getTotal() + shopConfig.deliveryFee)}*\n`;
        }
        
        message += '\n' + shopConfig.whatsapp.footer;
        
        return message;
    }

    // Send order via WhatsApp
    sendToWhatsApp() {
        if (this.items.length === 0) {
            alert('Seu carrinho está vazio!');
            return;
        }
        
        if (this.getTotal() < shopConfig.minimumOrderAmount) {
            alert(`Valor mínimo do pedido: ${formatPrice(shopConfig.minimumOrderAmount)}`);
            return;
        }
        
        const message = this.generateWhatsAppMessage();
        const encodedMessage = encodeURIComponent(message);
        const whatsappUrl = `https://wa.me/${shopConfig.whatsapp.number}?text=${encodedMessage}`;
        
        window.open(whatsappUrl, '_blank');
    }

    // Go to checkout (for online payment)
    goToCheckout() {
        if (this.items.length === 0) {
            alert('Seu carrinho está vazio!');
            return;
        }
        
        if (this.getTotal() < shopConfig.minimumOrderAmount) {
            alert(`Valor mínimo do pedido: ${formatPrice(shopConfig.minimumOrderAmount)}`);
            return;
        }
        
        // TODO: Implement checkout page redirect
        alert('Redirecionando para o checkout...');
        // window.location.href = '/checkout';
    }
}

// Initialize cart
const cart = new ShoppingCart();

// Format price helper
function formatPrice(price) {
    return 'R$ ' + price.toFixed(2).replace('.', ',');
}

// ============================================
// DOM ELEMENTS
// ============================================
const filterToggleBtn = document.getElementById('filter-toggle-btn');
const filtersSidebar = document.getElementById('filters-sidebar');
const filtersClose = document.getElementById('filters-close');
const filtersApply = document.getElementById('filters-apply');
const quickViewOverlay = document.getElementById('quick-view-overlay');
const quickViewClose = document.getElementById('quick-view-close');
const priceRange = document.getElementById('price-range');
const priceValue = document.getElementById('price-value');

// ============================================
// MOBILE FILTER TOGGLE
// ============================================
if (filterToggleBtn) {
    filterToggleBtn.addEventListener('click', () => {
        filtersSidebar.classList.add('filters--mobile-open');
        document.body.style.overflow = 'hidden';
    });
}

if (filtersClose) {
    filtersClose.addEventListener('click', closeFilters);
}

if (filtersApply) {
    filtersApply.addEventListener('click', closeFilters);
}

function closeFilters() {
    filtersSidebar.classList.remove('filters--mobile-open');
    document.body.style.overflow = '';
}

// ============================================
// PRICE RANGE SLIDER
// ============================================
if (priceRange) {
    priceRange.addEventListener('input', (e) => {
        priceValue.textContent = formatPrice(parseInt(e.target.value));
    });
}

// ============================================
// QUICK VIEW MODAL
// ============================================
const quickViewButtons = document.querySelectorAll('.product-card__quick-view');
let currentQuickViewProduct = null;

quickViewButtons.forEach(btn => {
    btn.addEventListener('click', (e) => {
        const productId = parseInt(btn.dataset.productId);
        const product = productsData.find(p => p.id === productId);
        
        if (product) {
            currentQuickViewProduct = product;
            document.getElementById('quick-view-image').src = product.image;
            document.getElementById('quick-view-image').alt = product.name;
            document.getElementById('quick-view-category').textContent = product.category;
            document.getElementById('quick-view-title').textContent = product.name;
            document.getElementById('quick-view-price').textContent = formatPrice(product.price);
            document.getElementById('quick-view-description').textContent = product.description;
            document.getElementById('qty-value').textContent = '1';
            
            quickViewOverlay.classList.add('quick-view-overlay--open');
            document.body.style.overflow = 'hidden';
        }
    });
});

if (quickViewClose) {
    quickViewClose.addEventListener('click', closeQuickView);
}

if (quickViewOverlay) {
    quickViewOverlay.addEventListener('click', (e) => {
        if (e.target === quickViewOverlay) {
            closeQuickView();
        }
    });
}

function closeQuickView() {
    quickViewOverlay.classList.remove('quick-view-overlay--open');
    document.body.style.overflow = '';
    currentQuickViewProduct = null;
}

// ============================================
// QUANTITY CONTROLS
// ============================================
const qtyDecrease = document.getElementById('qty-decrease');
const qtyIncrease = document.getElementById('qty-increase');
const qtyValue = document.getElementById('qty-value');

if (qtyDecrease) {
    qtyDecrease.addEventListener('click', () => {
        let qty = parseInt(qtyValue.textContent);
        if (qty > 1) {
            qtyValue.textContent = qty - 1;
        }
    });
}

if (qtyIncrease) {
    qtyIncrease.addEventListener('click', () => {
        let qty = parseInt(qtyValue.textContent);
        if (qty < 99) {
            qtyValue.textContent = qty + 1;
        }
    });
}

// ============================================
// ADD TO CART BUTTONS
// ============================================
const addToCartButtons = document.querySelectorAll('.product-card__add-btn');

addToCartButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        const productId = parseInt(btn.dataset.productId);
        const product = productsData.find(p => p.id === productId);
        
        if (product) {
            cart.addItem(product, 1);
            
            // Button feedback animation
            btn.style.transform = 'scale(0.9)';
            btn.style.background = '#22c55e';
            setTimeout(() => {
                btn.style.transform = 'scale(1)';
                btn.style.background = '';
            }, 300);
        }
    });
});

// Quick View Add to Cart
const quickViewAdd = document.getElementById('quick-view-add');
if (quickViewAdd) {
    quickViewAdd.addEventListener('click', () => {
        if (currentQuickViewProduct) {
            const qty = parseInt(qtyValue.textContent);
            cart.addItem(currentQuickViewProduct, qty);
            closeQuickView();
        }
    });
}

// ============================================
// MOBILE CART BAR ACTION
// ============================================
const mobileCartBtn = document.querySelector('.mobile-cart-bar__btn');
if (mobileCartBtn) {
    mobileCartBtn.addEventListener('click', (e) => {
        e.preventDefault();
        
        if (shopConfig.onlinePaymentEnabled) {
            cart.goToCheckout();
        } else {
            cart.sendToWhatsApp();
        }
    });
}

// ============================================
// TOP NAV CART BUTTON ACTION
// ============================================
const topNavCartBtn = document.getElementById('cart-toggle');
if (topNavCartBtn) {
    topNavCartBtn.addEventListener('click', (e) => {
        e.preventDefault();
        
        if (cart.getItemCount() === 0) {
            cart.showNotification('Seu carrinho está vazio!');
            return;
        }
        
        if (shopConfig.onlinePaymentEnabled) {
            cart.goToCheckout();
        } else {
            cart.sendToWhatsApp();
        }
    });
}

// ============================================
// PRODUCT FILTERING SYSTEM
// ============================================
const ProductFilter = {
    searchTerm: '',
    selectedCategories: [],
    maxPrice: 200,
    selectedBadges: [],
    sortBy: 'popular',

    init() {
        this.bindEvents();
        this.collectInitialCategories();
        this.applyFilters();
    },

    collectInitialCategories() {
        const checkboxes = document.querySelectorAll('.filters__category-checkbox:checked');
        this.selectedCategories = Array.from(checkboxes).map(cb => cb.value);
    },

    bindEvents() {
        // Search input
        const searchInput = document.getElementById('filter-search');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                this.searchTerm = e.target.value.toLowerCase();
                this.applyFilters();
            });
        }

        // Top nav search
        const topNavSearch = document.querySelector('.top-nav__search-input');
        if (topNavSearch) {
            topNavSearch.addEventListener('input', (e) => {
                this.searchTerm = e.target.value.toLowerCase();
                if (searchInput) searchInput.value = e.target.value;
                this.applyFilters();
            });
        }

        // Category checkboxes
        const categoryCheckboxes = document.querySelectorAll('.filters__category-checkbox');
        categoryCheckboxes.forEach(cb => {
            cb.addEventListener('change', () => {
                this.selectedCategories = Array.from(
                    document.querySelectorAll('.filters__category-checkbox:checked')
                ).map(c => c.value);
                this.applyFilters();
            });
        });

        // Price range
        const priceRange = document.getElementById('price-range');
        if (priceRange) {
            priceRange.addEventListener('input', (e) => {
                this.maxPrice = parseInt(e.target.value);
                document.getElementById('price-value').textContent = formatPrice(this.maxPrice);
                this.applyFilters();
            });
        }

        // Tag filters
        const filterTags = document.querySelectorAll('.filters__tag');
        filterTags.forEach(tag => {
            tag.addEventListener('click', () => {
                tag.classList.toggle('filters__tag--active');
                this.selectedBadges = Array.from(
                    document.querySelectorAll('.filters__tag--active')
                ).map(t => t.dataset.badge);
                this.applyFilters();
            });
        });

        // Sort select
        const sortSelect = document.querySelector('.filter-toggle__sort select');
        if (sortSelect) {
            sortSelect.addEventListener('change', (e) => {
                this.sortBy = e.target.value;
                this.applyFilters();
            });
        }

        // Apply filters button
        const applyBtn = document.getElementById('filters-apply');
        if (applyBtn) {
            applyBtn.addEventListener('click', () => {
                this.applyFilters();
                closeFilters();
            });
        }

        // Categories bar quick filter
        const categoryLinks = document.querySelectorAll('.categories-bar__link');
        categoryLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                categoryLinks.forEach(l => l.classList.remove('categories-bar__link--active'));
                link.classList.add('categories-bar__link--active');
                
                const categoryText = link.querySelector('span:last-child')?.textContent?.toLowerCase() || '';
                
                if (categoryText === 'todos' || categoryText === 'promoções') {
                    // Show all or show promos
                    document.querySelectorAll('.filters__category-checkbox').forEach(cb => cb.checked = true);
                    this.collectInitialCategories();
                    
                    if (categoryText === 'promoções') {
                        this.selectedBadges = ['sale'];
                        document.querySelectorAll('.filters__tag').forEach(t => {
                            t.classList.toggle('filters__tag--active', t.dataset.badge === 'sale');
                        });
                    } else {
                        this.selectedBadges = [];
                        document.querySelectorAll('.filters__tag').forEach(t => t.classList.remove('filters__tag--active'));
                    }
                } else {
                    // Filter by specific category
                    document.querySelectorAll('.filters__category-checkbox').forEach(cb => {
                        const match = cb.value.toLowerCase() === categoryText;
                        cb.checked = match;
                    });
                    this.selectedCategories = [categoryText];
                    this.selectedBadges = [];
                    document.querySelectorAll('.filters__tag').forEach(t => t.classList.remove('filters__tag--active'));
                }
                
                this.applyFilters();
            });
        });
    },

    applyFilters() {
        const products = document.querySelectorAll('.product-card');
        let visibleCount = 0;
        let productsArray = Array.from(products);

        // Sort products
        productsArray = this.sortProducts(productsArray);
        
        // Reorder DOM
        const grid = document.getElementById('products-grid');
        productsArray.forEach(product => grid.appendChild(product));

        // Filter products
        productsArray.forEach(product => {
            const category = product.dataset.category || '';
            const name = product.dataset.name || '';
            const price = parseFloat(product.dataset.price) || 0;
            const badge = product.dataset.badge || '';

            let show = true;

            // Search filter
            if (this.searchTerm && !name.includes(this.searchTerm) && !category.includes(this.searchTerm)) {
                show = false;
            }

            // Category filter
            if (this.selectedCategories.length > 0 && !this.selectedCategories.includes(category)) {
                show = false;
            }

            // Price filter
            if (price > this.maxPrice) {
                show = false;
            }

            // Badge filter
            if (this.selectedBadges.length > 0 && !this.selectedBadges.includes(badge)) {
                show = false;
            }

            // Show/hide product
            if (show) {
                product.style.display = '';
                product.style.opacity = '1';
                product.style.transform = 'translateY(0)';
                visibleCount++;
            } else {
                product.style.display = 'none';
            }
        });

        // Show "no results" message if needed
        this.updateNoResultsMessage(visibleCount);
    },

    sortProducts(products) {
        return products.sort((a, b) => {
            const priceA = parseFloat(a.dataset.price) || 0;
            const priceB = parseFloat(b.dataset.price) || 0;
            const nameA = a.dataset.name || '';
            const nameB = b.dataset.name || '';

            switch (this.sortBy) {
                case 'price-low':
                    return priceA - priceB;
                case 'price-high':
                    return priceB - priceA;
                case 'newest':
                    return parseInt(b.dataset.productId) - parseInt(a.dataset.productId);
                case 'rating':
                    return 0; // Would need rating data
                case 'popular':
                default:
                    return 0;
            }
        });
    },

    updateNoResultsMessage(count) {
        let noResults = document.getElementById('no-results-message');
        
        if (count === 0) {
            if (!noResults) {
                noResults = document.createElement('div');
                noResults.id = 'no-results-message';
                noResults.className = 'no-results';
                noResults.innerHTML = `
                    <div class="no-results__icon">🔍</div>
                    <h3 class="no-results__title">Nenhum produto encontrado</h3>
                    <p class="no-results__text">Tente ajustar os filtros ou buscar por outro termo.</p>
                    <button class="no-results__btn" onclick="ProductFilter.clearFilters()">Limpar Filtros</button>
                `;
                document.getElementById('products-grid').appendChild(noResults);
            }
            noResults.style.display = 'flex';
        } else if (noResults) {
            noResults.style.display = 'none';
        }
    },

    clearFilters() {
        // Reset search
        this.searchTerm = '';
        const searchInput = document.getElementById('filter-search');
        if (searchInput) searchInput.value = '';
        const topNavSearch = document.querySelector('.top-nav__search-input');
        if (topNavSearch) topNavSearch.value = '';

        // Reset categories
        document.querySelectorAll('.filters__category-checkbox').forEach(cb => cb.checked = true);
        this.collectInitialCategories();

        // Reset price
        this.maxPrice = 200;
        const priceRange = document.getElementById('price-range');
        if (priceRange) priceRange.value = 200;
        const priceValue = document.getElementById('price-value');
        if (priceValue) priceValue.textContent = formatPrice(200);

        // Reset badges
        this.selectedBadges = [];
        document.querySelectorAll('.filters__tag').forEach(t => t.classList.remove('filters__tag--active'));

        // Reset category bar
        const categoryLinks = document.querySelectorAll('.categories-bar__link');
        categoryLinks.forEach((l, i) => l.classList.toggle('categories-bar__link--active', i === 0));

        // Apply
        this.applyFilters();
    }
};

// Initialize filter system
ProductFilter.init();

// ============================================
// KEYBOARD NAVIGATION
// ============================================
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeQuickView();
        closeFilters();
    }
});

// ============================================
// ANIMATIONS
// ============================================
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

document.querySelectorAll('.animate-fade-in').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(20px)';
    el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(el);
});

// Smooth Scroll for Hero CTA
document.querySelector('.hero__cta')?.addEventListener('click', (e) => {
    e.preventDefault();
    const target = document.querySelector('#produtos');
    if (target) {
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
});

// ============================================
// INITIALIZE UI
// ============================================
cart.updateUI();
</script>

<style>
/* Cart Notification */
.cart-notification {
    position: fixed;
    bottom: 100px;
    left: 50%;
    transform: translateX(-50%) translateY(20px);
    background: #1a1a2e;
    color: white;
    padding: 0.875rem 1.5rem;
    border-radius: 50px;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.9375rem;
    font-weight: 500;
    box-shadow: 0 10px 40px rgba(0,0,0,0.3);
    z-index: 9999;
    opacity: 0;
    transition: all 0.3s ease;
}

.cart-notification.show {
    opacity: 1;
    transform: translateX(-50%) translateY(0);
}

.cart-notification__icon {
    width: 24px;
    height: 24px;
    background: #22c55e;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
}

@media (min-width: 768px) {
    .cart-notification {
        bottom: 40px;
    }
}
</style>
<?php $this->end(); ?>
