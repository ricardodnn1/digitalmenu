<?php
declare(strict_types=1);

namespace App\Service\Payment;

use App\Model\Entity\PaymentMethod;

/**
 * Payment Gateway Interface
 * 
 * Defines the contract for payment gateway implementations
 */
interface PaymentGatewayInterface
{
    /**
     * Constructor
     *
     * @param PaymentMethod $paymentMethod
     */
    public function __construct(PaymentMethod $paymentMethod);

    /**
     * Test the connection with the payment gateway
     *
     * @return array{success: bool, message: string}
     */
    public function testConnection(): array;

    /**
     * Create a payment/charge
     *
     * @param array $data Payment data
     * @return array{success: bool, external_id?: string, status?: string, data?: array, error?: string}
     */
    public function createPayment(array $data): array;

    /**
     * Create a PIX payment
     *
     * @param array $data Payment data
     * @return array{success: bool, external_id?: string, qr_code?: string, qr_code_url?: string, expires_at?: string, error?: string}
     */
    public function createPixPayment(array $data): array;

    /**
     * Create a Boleto payment
     *
     * @param array $data Payment data
     * @return array{success: bool, external_id?: string, barcode?: string, url?: string, due_date?: string, error?: string}
     */
    public function createBoletoPayment(array $data): array;

    /**
     * Get payment status
     *
     * @param string $externalId External payment ID
     * @return array{success: bool, status?: string, data?: array, error?: string}
     */
    public function getPaymentStatus(string $externalId): array;

    /**
     * Refund a payment
     *
     * @param string $externalId External payment ID
     * @param float|null $amount Partial refund amount (null for full refund)
     * @return array{success: bool, refund_id?: string, error?: string}
     */
    public function refund(string $externalId, ?float $amount = null): array;

    /**
     * Cancel a payment
     *
     * @param string $externalId External payment ID
     * @return array{success: bool, error?: string}
     */
    public function cancel(string $externalId): array;

    /**
     * Validate webhook signature
     *
     * @param string $payload Raw request body
     * @param string $signature Signature from header
     * @return bool
     */
    public function validateWebhookSignature(string $payload, string $signature): bool;

    /**
     * Get supported payment methods
     *
     * @return array
     */
    public function getSupportedMethods(): array;
}
