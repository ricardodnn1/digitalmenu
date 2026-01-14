<?php
declare(strict_types=1);

namespace App\Service\Payment;

/**
 * Stripe Payment Gateway Service
 * 
 * @see https://stripe.com/docs/api
 */
class StripeService extends AbstractPaymentGateway
{
    /**
     * Get API base URL
     *
     * @return string
     */
    protected function getBaseUrl(): string
    {
        return 'https://api.stripe.com/v1';
    }

    /**
     * Get default headers
     *
     * @return array
     */
    protected function getDefaultHeaders(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->getApiKey(),
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Stripe-Version' => '2023-10-16',
        ];
    }

    /**
     * Make request with form-urlencoded data (Stripe specific)
     *
     * @param string $method
     * @param string $endpoint
     * @param array $data
     * @param array $headers
     * @return array
     */
    protected function request(string $method, string $endpoint, array $data = [], array $headers = []): array
    {
        $url = $this->getBaseUrl() . $endpoint;
        
        $defaultHeaders = $this->getDefaultHeaders();
        $headers = array_merge($defaultHeaders, $headers);

        try {
            $response = match (strtoupper($method)) {
                'GET' => $this->httpClient->get($url, $data, ['headers' => $headers]),
                'POST' => $this->httpClient->post($url, http_build_query($this->flattenArray($data)), ['headers' => $headers]),
                'DELETE' => $this->httpClient->delete($url, $data, ['headers' => $headers]),
                default => throw new \InvalidArgumentException("Invalid HTTP method: {$method}"),
            };

            $body = $response->getJson() ?? [];
            
            if (!$response->isOk()) {
                return [
                    'success' => false,
                    'error' => $body['error']['message'] ?? 'Unknown error',
                    'status_code' => $response->getStatusCode(),
                    'data' => $body,
                ];
            }

            return [
                'success' => true,
                'data' => $body,
                'status_code' => $response->getStatusCode(),
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Flatten array for form-urlencoded
     *
     * @param array $data
     * @param string $prefix
     * @return array
     */
    protected function flattenArray(array $data, string $prefix = ''): array
    {
        $result = [];
        
        foreach ($data as $key => $value) {
            $newKey = $prefix ? "{$prefix}[{$key}]" : $key;
            
            if (is_array($value)) {
                $result = array_merge($result, $this->flattenArray($value, $newKey));
            } else {
                $result[$newKey] = $value;
            }
        }
        
        return $result;
    }

    /**
     * Test connection
     *
     * @return array
     */
    public function testConnection(): array
    {
        $response = $this->request('GET', '/balance');
        
        if ($response['success']) {
            $balance = $response['data']['available'][0]['amount'] ?? 0;
            return [
                'success' => true,
                'message' => 'Conectado! Saldo disponível: R$ ' . number_format($balance / 100, 2, ',', '.'),
            ];
        }

        return [
            'success' => false,
            'message' => $response['error'] ?? 'Falha ao conectar',
        ];
    }

    /**
     * Create payment (Payment Intent)
     *
     * @param array $data
     * @return array
     */
    public function createPayment(array $data): array
    {
        // First, create or get customer
        $customerId = $this->getOrCreateCustomer($data);
        
        // Create Payment Method
        $paymentMethodResponse = $this->request('POST', '/payment_methods', [
            'type' => 'card',
            'card' => [
                'number' => $data['card_number'],
                'exp_month' => $data['card_exp_month'],
                'exp_year' => $data['card_exp_year'],
                'cvc' => $data['card_cvv'],
            ],
            'billing_details' => [
                'name' => $data['card_holder_name'],
                'email' => $data['customer_email'],
            ],
        ]);

        if (!$paymentMethodResponse['success']) {
            return [
                'success' => false,
                'error' => $paymentMethodResponse['error'],
            ];
        }

        $paymentMethodId = $paymentMethodResponse['data']['id'];

        // Create Payment Intent
        $payload = [
            'amount' => $this->toCents($data['amount']),
            'currency' => 'brl',
            'payment_method' => $paymentMethodId,
            'customer' => $customerId,
            'confirm' => 'true',
            'description' => $data['description'] ?? 'Pedido',
            'metadata' => [
                'order_id' => $data['order_id'] ?? '',
                'reference' => $data['reference_id'] ?? '',
            ],
        ];

        $response = $this->request('POST', '/payment_intents', $payload);
        
        if ($response['success']) {
            $intent = $response['data'];
            return [
                'success' => true,
                'external_id' => $intent['id'],
                'status' => $this->mapStatus($intent['status']),
                'data' => $intent,
            ];
        }

        return [
            'success' => false,
            'error' => $response['error'],
        ];
    }

    /**
     * Create PIX payment (not native in Stripe, use alternative)
     *
     * @param array $data
     * @return array
     */
    public function createPixPayment(array $data): array
    {
        // Stripe doesn't natively support PIX in Brazil yet
        // This would require Stripe's Brazil-specific integration or third-party
        return [
            'success' => false,
            'error' => 'PIX não suportado nativamente pelo Stripe. Use Pagar.me ou PagSeguro.',
        ];
    }

    /**
     * Create Boleto payment (not native in Stripe)
     *
     * @param array $data
     * @return array
     */
    public function createBoletoPayment(array $data): array
    {
        // Stripe doesn't natively support Boleto
        return [
            'success' => false,
            'error' => 'Boleto não suportado nativamente pelo Stripe. Use Pagar.me ou PagSeguro.',
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
        $response = $this->request('GET', "/payment_intents/{$externalId}");
        
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
        $payload = [
            'payment_intent' => $externalId,
        ];
        
        if ($amount !== null) {
            $payload['amount'] = $this->toCents($amount);
        }

        $response = $this->request('POST', '/refunds', $payload);
        
        if ($response['success']) {
            return [
                'success' => true,
                'refund_id' => $response['data']['id'],
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
        $response = $this->request('POST', "/payment_intents/{$externalId}/cancel");
        
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
        
        if (!$webhookSecret || !$signature) {
            return false;
        }

        // Parse Stripe signature header
        $sigParts = [];
        foreach (explode(',', $signature) as $part) {
            [$key, $value] = explode('=', $part, 2);
            $sigParts[$key] = $value;
        }

        $timestamp = $sigParts['t'] ?? '';
        $expectedSig = $sigParts['v1'] ?? '';

        if (!$timestamp || !$expectedSig) {
            return false;
        }

        // Compute signature
        $signedPayload = "{$timestamp}.{$payload}";
        $computedSig = hash_hmac('sha256', $signedPayload, $webhookSecret);

        return hash_equals($computedSig, $expectedSig);
    }

    /**
     * Get or create Stripe customer
     *
     * @param array $data
     * @return string|null
     */
    protected function getOrCreateCustomer(array $data): ?string
    {
        // Search for existing customer
        $searchResponse = $this->request('GET', '/customers', [
            'email' => $data['customer_email'],
            'limit' => 1,
        ]);

        if ($searchResponse['success'] && !empty($searchResponse['data']['data'])) {
            return $searchResponse['data']['data'][0]['id'];
        }

        // Create new customer
        $createResponse = $this->request('POST', '/customers', [
            'email' => $data['customer_email'],
            'name' => $data['customer_name'],
            'metadata' => [
                'document' => $data['customer_document'] ?? '',
            ],
        ]);

        if ($createResponse['success']) {
            return $createResponse['data']['id'];
        }

        return null;
    }

    /**
     * Map Stripe status to internal status
     *
     * @param string $status
     * @return string
     */
    protected function mapStatus(string $status): string
    {
        return match ($status) {
            'succeeded' => 'approved',
            'processing' => 'processing',
            'requires_payment_method', 'requires_confirmation', 'requires_action' => 'pending',
            'canceled' => 'cancelled',
            default => 'pending',
        };
    }
}
