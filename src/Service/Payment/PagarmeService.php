<?php
declare(strict_types=1);

namespace App\Service\Payment;

/**
 * Pagar.me Payment Gateway Service
 * 
 * @see https://docs.pagar.me/
 */
class PagarmeService extends AbstractPaymentGateway
{
    /**
     * Get API base URL
     *
     * @return string
     */
    protected function getBaseUrl(): string
    {
        return $this->isSandbox()
            ? 'https://api.pagar.me/core/v5'
            : 'https://api.pagar.me/core/v5';
    }

    /**
     * Get default headers
     *
     * @return array
     */
    protected function getDefaultHeaders(): array
    {
        $apiKey = $this->getApiKey();
        
        return [
            'Authorization' => 'Basic ' . base64_encode($apiKey . ':'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    /**
     * Test connection
     *
     * @return array
     */
    public function testConnection(): array
    {
        $response = $this->request('GET', '/merchants/me');
        
        if ($response['success']) {
            return [
                'success' => true,
                'message' => 'Conectado como: ' . ($response['data']['name'] ?? 'N/A'),
            ];
        }

        return [
            'success' => false,
            'message' => $response['error'] ?? 'Falha ao conectar',
        ];
    }

    /**
     * Create payment (credit card)
     *
     * @param array $data
     * @return array
     */
    public function createPayment(array $data): array
    {
        $payload = [
            'items' => [
                [
                    'amount' => $this->toCents($data['amount']),
                    'description' => $data['description'] ?? 'Pedido',
                    'quantity' => 1,
                ],
            ],
            'customer' => [
                'name' => $data['customer_name'],
                'email' => $data['customer_email'],
                'document' => $this->formatDocument($data['customer_document']),
                'type' => strlen($this->formatDocument($data['customer_document'])) === 11 ? 'individual' : 'company',
                'phones' => [
                    'mobile_phone' => $this->formatPhone($data['customer_phone'] ?? ''),
                ],
            ],
            'payments' => [
                [
                    'payment_method' => 'credit_card',
                    'credit_card' => [
                        'card' => [
                            'number' => $data['card_number'],
                            'holder_name' => $data['card_holder_name'],
                            'exp_month' => $data['card_exp_month'],
                            'exp_year' => $data['card_exp_year'],
                            'cvv' => $data['card_cvv'],
                        ],
                        'installments' => $data['installments'] ?? 1,
                        'statement_descriptor' => substr($data['statement_descriptor'] ?? 'LORDLION', 0, 13),
                    ],
                ],
            ],
        ];

        $response = $this->request('POST', '/orders', $payload);
        
        if ($response['success']) {
            $order = $response['data'];
            return [
                'success' => true,
                'external_id' => $order['id'],
                'status' => $this->mapStatus($order['status']),
                'data' => $order,
            ];
        }

        return [
            'success' => false,
            'error' => $response['error'],
        ];
    }

    /**
     * Create PIX payment
     *
     * @param array $data
     * @return array
     */
    public function createPixPayment(array $data): array
    {
        $payload = [
            'items' => [
                [
                    'amount' => $this->toCents($data['amount']),
                    'description' => $data['description'] ?? 'Pedido',
                    'quantity' => 1,
                ],
            ],
            'customer' => [
                'name' => $data['customer_name'],
                'email' => $data['customer_email'],
                'document' => $this->formatDocument($data['customer_document']),
                'type' => strlen($this->formatDocument($data['customer_document'])) === 11 ? 'individual' : 'company',
            ],
            'payments' => [
                [
                    'payment_method' => 'pix',
                    'pix' => [
                        'expires_in' => $data['expires_in'] ?? 3600, // 1 hour
                    ],
                ],
            ],
        ];

        $response = $this->request('POST', '/orders', $payload);
        
        if ($response['success']) {
            $order = $response['data'];
            $pix = $order['charges'][0]['last_transaction'] ?? [];
            
            return [
                'success' => true,
                'external_id' => $order['id'],
                'qr_code' => $pix['qr_code'] ?? null,
                'qr_code_url' => $pix['qr_code_url'] ?? null,
                'expires_at' => $pix['expires_at'] ?? null,
                'data' => $order,
            ];
        }

        return [
            'success' => false,
            'error' => $response['error'],
        ];
    }

    /**
     * Create Boleto payment
     *
     * @param array $data
     * @return array
     */
    public function createBoletoPayment(array $data): array
    {
        $dueDate = $data['due_date'] ?? date('Y-m-d', strtotime('+3 days'));
        
        $payload = [
            'items' => [
                [
                    'amount' => $this->toCents($data['amount']),
                    'description' => $data['description'] ?? 'Pedido',
                    'quantity' => 1,
                ],
            ],
            'customer' => [
                'name' => $data['customer_name'],
                'email' => $data['customer_email'],
                'document' => $this->formatDocument($data['customer_document']),
                'type' => strlen($this->formatDocument($data['customer_document'])) === 11 ? 'individual' : 'company',
                'address' => [
                    'line_1' => $data['address_line1'] ?? '',
                    'zip_code' => $data['address_zipcode'] ?? '',
                    'city' => $data['address_city'] ?? '',
                    'state' => $data['address_state'] ?? '',
                    'country' => 'BR',
                ],
            ],
            'payments' => [
                [
                    'payment_method' => 'boleto',
                    'boleto' => [
                        'due_at' => $dueDate,
                        'instructions' => $data['instructions'] ?? 'Não receber após vencimento',
                    ],
                ],
            ],
        ];

        $response = $this->request('POST', '/orders', $payload);
        
        if ($response['success']) {
            $order = $response['data'];
            $boleto = $order['charges'][0]['last_transaction'] ?? [];
            
            return [
                'success' => true,
                'external_id' => $order['id'],
                'barcode' => $boleto['line'] ?? null,
                'url' => $boleto['pdf'] ?? $boleto['url'] ?? null,
                'due_date' => $dueDate,
                'data' => $order,
            ];
        }

        return [
            'success' => false,
            'error' => $response['error'],
        ];
    }

    /**
     * Get payment status
     *
     * @param string $externalId
     * @return array
     */
    public function getPaymentStatus(string $externalId): array
    {
        $response = $this->request('GET', "/orders/{$externalId}");
        
        if ($response['success']) {
            return [
                'success' => true,
                'status' => $this->mapStatus($response['data']['status']),
                'data' => $response['data'],
            ];
        }

        return [
            'success' => false,
            'error' => $response['error'],
        ];
    }

    /**
     * Refund payment
     *
     * @param string $externalId
     * @param float|null $amount
     * @return array
     */
    public function refund(string $externalId, ?float $amount = null): array
    {
        // Get order to find charge id
        $orderResponse = $this->request('GET', "/orders/{$externalId}");
        
        if (!$orderResponse['success']) {
            return ['success' => false, 'error' => 'Order not found'];
        }

        $chargeId = $orderResponse['data']['charges'][0]['id'] ?? null;
        
        if (!$chargeId) {
            return ['success' => false, 'error' => 'Charge not found'];
        }

        $payload = [];
        if ($amount !== null) {
            $payload['amount'] = $this->toCents($amount);
        }

        $response = $this->request('POST', "/charges/{$chargeId}/refund", $payload);
        
        if ($response['success']) {
            return [
                'success' => true,
                'refund_id' => $response['data']['id'] ?? null,
            ];
        }

        return [
            'success' => false,
            'error' => $response['error'],
        ];
    }

    /**
     * Cancel payment
     *
     * @param string $externalId
     * @return array
     */
    public function cancel(string $externalId): array
    {
        $response = $this->request('DELETE', "/orders/{$externalId}");
        
        return [
            'success' => $response['success'],
            'error' => $response['error'] ?? null,
        ];
    }

    /**
     * Validate webhook signature
     *
     * @param string $payload
     * @param string $signature
     * @return bool
     */
    public function validateWebhookSignature(string $payload, string $signature): bool
    {
        $webhookSecret = $this->paymentMethod->webhook_secret;
        
        if (!$webhookSecret) {
            return false;
        }

        $expectedSignature = hash_hmac('sha256', $payload, $webhookSecret);
        
        return hash_equals($expectedSignature, $signature);
    }

    /**
     * Map Pagar.me status to internal status
     *
     * @param string $status
     * @return string
     */
    protected function mapStatus(string $status): string
    {
        return match ($status) {
            'paid' => 'approved',
            'pending' => 'pending',
            'processing' => 'processing',
            'failed' => 'declined',
            'canceled' => 'cancelled',
            'refunded' => 'refunded',
            default => 'pending',
        };
    }
}
