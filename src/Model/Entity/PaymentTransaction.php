<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PaymentTransaction Entity
 *
 * @property int $id
 * @property int $payment_method_id
 * @property int|null $order_id
 * @property string|null $external_id
 * @property string|null $reference_code
 * @property float $amount
 * @property string $currency
 * @property string $status
 * @property string|null $payment_type
 * @property int|null $installments
 * @property string|null $customer_name
 * @property string|null $customer_email
 * @property string|null $customer_document
 * @property string|null $card_last_digits
 * @property string|null $card_brand
 * @property string|null $pix_qr_code
 * @property string|null $pix_qr_code_url
 * @property string|null $boleto_url
 * @property string|null $boleto_barcode
 * @property \Cake\I18n\Date|null $boleto_due_date
 * @property array|null $provider_response
 * @property string|null $error_code
 * @property string|null $error_message
 * @property \Cake\I18n\DateTime|null $paid_at
 * @property \Cake\I18n\DateTime|null $refunded_at
 * @property \Cake\I18n\DateTime|null $expires_at
 * @property array|null $metadata
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\PaymentMethod $payment_method
 */
class PaymentTransaction extends Entity
{
    /**
     * Status constants
     */
    public const STATUS_PENDING = 'pending';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_DECLINED = 'declined';
    public const STATUS_REFUNDED = 'refunded';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_EXPIRED = 'expired';

    /**
     * Status labels
     */
    public const STATUS_LABELS = [
        self::STATUS_PENDING => 'Pendente',
        self::STATUS_PROCESSING => 'Processando',
        self::STATUS_APPROVED => 'Aprovado',
        self::STATUS_DECLINED => 'Recusado',
        self::STATUS_REFUNDED => 'Reembolsado',
        self::STATUS_CANCELLED => 'Cancelado',
        self::STATUS_EXPIRED => 'Expirado',
    ];

    /**
     * Status colors for UI
     */
    public const STATUS_COLORS = [
        self::STATUS_PENDING => 'warning',
        self::STATUS_PROCESSING => 'info',
        self::STATUS_APPROVED => 'success',
        self::STATUS_DECLINED => 'danger',
        self::STATUS_REFUNDED => 'secondary',
        self::STATUS_CANCELLED => 'dark',
        self::STATUS_EXPIRED => 'secondary',
    ];

    /**
     * Fields that can be mass assigned
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'payment_method_id' => true,
        'order_id' => true,
        'external_id' => true,
        'reference_code' => true,
        'amount' => true,
        'currency' => true,
        'status' => true,
        'payment_type' => true,
        'installments' => true,
        'customer_name' => true,
        'customer_email' => true,
        'customer_document' => true,
        'card_last_digits' => true,
        'card_brand' => true,
        'pix_qr_code' => true,
        'pix_qr_code_url' => true,
        'boleto_url' => true,
        'boleto_barcode' => true,
        'boleto_due_date' => true,
        'provider_response' => true,
        'error_code' => true,
        'error_message' => true,
        'paid_at' => true,
        'refunded_at' => true,
        'expires_at' => true,
        'metadata' => true,
        'ip_address' => true,
        'user_agent' => true,
        'payment_method' => true,
        'created' => false,
        'modified' => false,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var list<string>
     */
    protected array $_hidden = [
        'provider_response',
        'user_agent',
    ];

    /**
     * Get status label
     *
     * @return string
     */
    protected function _getStatusLabel(): string
    {
        return self::STATUS_LABELS[$this->status] ?? $this->status;
    }

    /**
     * Get status color
     *
     * @return string
     */
    protected function _getStatusColor(): string
    {
        return self::STATUS_COLORS[$this->status] ?? 'secondary';
    }

    /**
     * Check if transaction is successful
     *
     * @return bool
     */
    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    /**
     * Check if transaction is pending
     *
     * @return bool
     */
    public function isPending(): bool
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_PROCESSING], true);
    }

    /**
     * Check if transaction failed
     *
     * @return bool
     */
    public function isFailed(): bool
    {
        return in_array($this->status, [self::STATUS_DECLINED, self::STATUS_CANCELLED, self::STATUS_EXPIRED], true);
    }

    /**
     * Get masked card number
     *
     * @return string|null
     */
    protected function _getMaskedCard(): ?string
    {
        if (empty($this->card_last_digits)) {
            return null;
        }
        
        return '**** **** **** ' . $this->card_last_digits;
    }

    /**
     * Get formatted amount
     *
     * @return string
     */
    protected function _getFormattedAmount(): string
    {
        return 'R$ ' . number_format($this->amount, 2, ',', '.');
    }
}
