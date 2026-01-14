<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WebhookLog Entity
 *
 * @property int $id
 * @property int|null $payment_method_id
 * @property string $provider
 * @property string $event_type
 * @property string|null $external_id
 * @property array $payload
 * @property array|null $headers
 * @property string|null $signature
 * @property bool|null $signature_valid
 * @property bool $processed
 * @property \Cake\I18n\DateTime|null $processed_at
 * @property string|null $error_message
 * @property string|null $ip_address
 * @property \Cake\I18n\DateTime $created
 *
 * @property \App\Model\Entity\PaymentMethod $payment_method
 */
class WebhookLog extends Entity
{
    /**
     * Fields that can be mass assigned
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'payment_method_id' => true,
        'provider' => true,
        'event_type' => true,
        'external_id' => true,
        'payload' => true,
        'headers' => true,
        'signature' => true,
        'signature_valid' => true,
        'processed' => true,
        'processed_at' => true,
        'error_message' => true,
        'ip_address' => true,
        'payment_method' => true,
        'created' => false,
    ];

    /**
     * Mark as processed
     *
     * @param string|null $errorMessage
     * @return void
     */
    public function markProcessed(?string $errorMessage = null): void
    {
        $this->processed = true;
        $this->processed_at = new \Cake\I18n\DateTime();
        
        if ($errorMessage) {
            $this->error_message = $errorMessage;
        }
    }
}
