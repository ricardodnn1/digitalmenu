<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Security;

/**
 * PaymentMethod Entity
 *
 * @property int $id
 * @property string $name
 * @property string $provider
 * @property bool $is_active
 * @property bool $is_default
 * @property string $environment
 * @property string|null $api_key
 * @property string|null $api_secret
 * @property string|null $webhook_secret
 * @property string|null $webhook_url
 * @property array|null $additional_config
 * @property array|null $supported_methods
 * @property float|null $fee_percentage
 * @property float|null $fee_fixed
 * @property float|null $min_amount
 * @property float|null $max_amount
 * @property int $display_order
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\PaymentTransaction[] $payment_transactions
 */
class PaymentMethod extends Entity
{
    /**
     * Fields that can be mass assigned
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'name' => true,
        'provider' => true,
        'is_active' => true,
        'is_default' => true,
        'environment' => true,
        'api_key' => true,
        'api_secret' => true,
        'webhook_secret' => true,
        'webhook_url' => true,
        'additional_config' => true,
        'supported_methods' => true,
        'fee_percentage' => true,
        'fee_fixed' => true,
        'min_amount' => true,
        'max_amount' => true,
        'display_order' => true,
        'created' => false,
        'modified' => false,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var list<string>
     */
    protected array $_hidden = [
        'api_key',
        'api_secret',
        'webhook_secret',
    ];

    /**
     * Provider display names
     */
    public const PROVIDERS = [
        'pagarme' => 'Pagar.me',
        'pagseguro' => 'PagSeguro',
        'stripe' => 'Stripe',
        'pix_manual' => 'PIX Manual',
        'cash' => 'Dinheiro',
        'boleto_manual' => 'Boleto Manual',
    ];

    /**
     * Payment types
     */
    public const PAYMENT_TYPES = [
        'credit_card' => 'Cartão de Crédito',
        'debit_card' => 'Cartão de Débito',
        'pix' => 'PIX',
        'boleto' => 'Boleto Bancário',
        'cash' => 'Dinheiro',
    ];

    /**
     * Get the decrypted API key
     *
     * @return string|null
     */
    protected function _getApiKeyDecrypted(): ?string
    {
        if (empty($this->api_key)) {
            return null;
        }
        
        try {
            return Security::decrypt(base64_decode($this->api_key), Security::getSalt());
        } catch (\Exception $e) {
            return $this->api_key;
        }
    }

    /**
     * Set encrypted API key
     *
     * @param string|null $value
     * @return string|null
     */
    protected function _setApiKey(?string $value): ?string
    {
        if (empty($value)) {
            return null;
        }
        
        // Don't re-encrypt if it's already encrypted
        if (strlen($value) > 100 && base64_decode($value, true) !== false) {
            return $value;
        }
        
        return base64_encode(Security::encrypt($value, Security::getSalt()));
    }

    /**
     * Get the decrypted API secret
     *
     * @return string|null
     */
    protected function _getApiSecretDecrypted(): ?string
    {
        if (empty($this->api_secret)) {
            return null;
        }
        
        try {
            return Security::decrypt(base64_decode($this->api_secret), Security::getSalt());
        } catch (\Exception $e) {
            return $this->api_secret;
        }
    }

    /**
     * Set encrypted API secret
     *
     * @param string|null $value
     * @return string|null
     */
    protected function _setApiSecret(?string $value): ?string
    {
        if (empty($value)) {
            return null;
        }
        
        if (strlen($value) > 100 && base64_decode($value, true) !== false) {
            return $value;
        }
        
        return base64_encode(Security::encrypt($value, Security::getSalt()));
    }

    /**
     * Get provider display name
     *
     * @return string
     */
    protected function _getProviderName(): string
    {
        return self::PROVIDERS[$this->provider] ?? $this->provider;
    }

    /**
     * Check if provider supports a payment type
     *
     * @param string $type
     * @return bool
     */
    public function supportsPaymentType(string $type): bool
    {
        $methods = $this->supported_methods ?? [];
        return in_array($type, $methods, true);
    }

    /**
     * Get provider logo path
     *
     * @return string
     */
    protected function _getProviderLogo(): string
    {
        $logos = [
            'pagarme' => '/img/payments/pagarme.svg',
            'pagseguro' => '/img/payments/pagseguro.svg',
            'stripe' => '/img/payments/stripe.svg',
            'pix_manual' => '/img/payments/pix.svg',
            'cash' => '/img/payments/cash.svg',
        ];
        
        return $logos[$this->provider] ?? '/img/payments/default.svg';
    }

    /**
     * Check if in sandbox mode
     *
     * @return bool
     */
    public function isSandbox(): bool
    {
        return $this->environment === 'sandbox';
    }

    /**
     * Check if in production mode
     *
     * @return bool
     */
    public function isProduction(): bool
    {
        return $this->environment === 'production';
    }
}
