<?php
declare(strict_types=1);

namespace App\Service\Payment;

/**
 * PagSeguro Payment Gateway Service
 * 
 * @see https://dev.pagbank.uol.com.br/reference
 */
class PagSeguroService extends AbstractPaymentGateway
{
    /**
     * Get API base URL
     *
     * @return string
     */
    protected function getBaseUrl(): string
    {
        return $this->isSandbox()
            ? 'https://sandbox.api.pagseguro.com'
            : 'https://api.pagseguro.com';
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
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'x-api-version' => '4.0',
        ];
    }

    /**
     * Test connection
     *
     * @return array
     */
    public function testConnection(): array
    {
        // PagSeguro doesn't have a direct "me" endpoint, test with public key validation
        $response = $this->request('GET', '/public-keys/card');
        
        if ($response['success'] || $response['status_code'] === 200) {
            return [
                'success' => true,
                'message' => 'Credenciais válidas',
            ];
        }

        return [
            'success' => false,
            'message' => $response['error'] ?? 'Falha ao validar credenciais',
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
            'reference_id' => $data['reference_id'] ?? uniqid('order_'),
            'customer' => [
                'name' => $data['customer_name'],
                'email' => $data['customer_email'],
                'tax_id' => $this->formatDocument($data['customer_document']),
                'phones' => [
                    [
                        'country' => '55',
                        'area' => substr(preg_replace('/\D/', '', $data['customer_phone'] ?? ''), 0, 2),
                        'number' => substr(preg_replace('/\D/', '', $data['customer_phone'] ?? ''), 2),
                        'type' => 'MOBILE',
                    ],
                ],
            ],
            'items' => [
                [
                    'reference_id' => 'item_1',
                    'name' => $data['description'] ?? 'Pedido',
                    'quantity' => 1,
                    'unit_amount' => $this->toCents($data['amount']),
                ],
            ],
            'charges' => [
                [
                    'reference_id' => 'charge_1',
                    'description' => $data['description'] ?? 'Pagamento',
                    'amount' => [
                        'value' => $this->toCents($data['amount']),
                        'currency' => 'BRL',
                    ],
                    'payment_method' => [
                        'type' => 'CREDIT_CARD',
                        'installments' => $data['installments'] ?? 1,
                        'capture' => true,
                        'card' => [
                            'number' => $data['card_number'],
                            'exp_month' => $data['card_exp_month'],
                            'exp_year' => $data['card_exp_year'],
                            'security_code' => $data['card_cvv'],
                            'holder' => [
                                'name' => $data['card_holder_name'],
                            ],
                        ],
                    ],
                ],
            ],
            'notification_urls' => [
                $this->paymentMethod->webhook_url,
            ],
        ];

        $response = $this->request('POST', '/orders', $payload);
        
        if ($response['success']) {
            $order = $response['data'];
            return [
                'success' => true,
                'external_id' => $order['id'],
                'status' => $this->mapStatus($order['charges'][0]['status'] ?? 'WAITING'),
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
        $expirationDate = date('c', strtotime('+' . ($data['expires_in'] ?? 3600) . ' seconds'));
        
        $payload = [
            'reference_id' => $data['reference_id'] ?? uniqid('pix_'),
            'customer' => [
                'name' => $data['customer_name'],
                'email' => $data['customer_email'],
                'tax_id' => $this->formatDocument($data['customer_document']),
            ],
            'items' => [
                [
                    'reference_id' => 'item_1',
                    'name' => $data['description'] ?? 'Pedido',
                    'quantity' => 1,
                    'unit_amount' => $this->toCents($data['amount']),
                ],
            ],
            'qr_codes' => [
                [
                    'amount' => [
                        'value' => $this->toCents($data['amount']),
                    ],
                    'expiration_date' => $expirationDate,
                ],
            ],
            'notification_urls' => [
                $this->paymentMethod->webhook_url,
            ],
        ];

        $response = $this->request('POST', '/orders', $payload);
        
        if ($response['success']) {
            $order = $response['data'];
            $qrCode = $order['qr_codes'][0] ?? [];
            
            return [
                'success' => true,
                'external_id' => $order['id'],
                'qr_code' => $qrCode['text'] ?? null,
                'qr_code_url' => $qrCode['links'][0]['href'] ?? null,
                'expires_at' => $expirationDate,
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
            'reference_id' => $data['reference_id'] ?? uniqid('boleto_'),
            'customer' => [
                'name' => $data['customer_name'],
                'email' => $data['customer_email'],
                'tax_id' => $this->formatDocument($data['customer_document']),
            ],
            'items' => [
                [
                    'reference_id' => 'item_1',
                    'name' => $data['description'] ?? 'Pedido',
                    'quantity' => 1,
                    'unit_amount' => $this->toCents($data['amount']),
                ],
            ],
            'charges' => [
                [
                    'reference_id' => 'charge_1',
                    'description' => $data['description'] ?? 'Pagamento',
                    'amount' => [
                        'value' => $this->toCents($data['amount']),
                        'currency' => 'BRL',
                    ],
                    'payment_method' => [
                        'type' => 'BOLETO',
                        'boleto' => [
                            'due_date' => $dueDate,
                            'instruction_lines' => [
                                'line_1' => $data['instructions'] ?? 'Não receber após vencimento',
                                'line_2' => 'Pagamento referente ao pedido',
                            ],
                            'holder' => [
                                'name' => $data['customer_name'],
                                'tax_id' => $this->formatDocument($data['customer_document']),
                                'email' => $data['customer_email'],
                                'address' => [
                                    'street' => $data['address_street'] ?? 'Rua não informada',
                                    'number' => $data['address_number'] ?? 'S/N',
                                    'locality' => $data['address_neighborhood'] ?? '',
                                    'city' => $data['address_city'] ?? '',
                                    'region_code' => $data['address_state'] ?? 'SP',
                                    'country' => 'BRA',
                                    'postal_code' => preg_replace('/\D/', '', $data['address_zipcode'] ?? ''),
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'notification_urls' => [
                $this->paymentMethod->webhook_url,
            ],
        ];

        $response = $this->request('POST', '/orders', $payload);
        
        if ($response['success']) {
            $order = $response['data'];
            $boleto = $order['charges'][0]['payment_method']['boleto'] ?? [];
            
            return [
                'success' => true,
                'external_id' => $order['id'],
                'barcode' => $boleto['barcode'] ?? null,
                'url' => $order['links'][0]['href'] ?? null,
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
            $status = $response['data']['charges'][0]['status'] ?? 'WAITING';
            return [
                'success' => true,
                'status' => $this->mapStatus($status),
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

        $payload = [
            'amount' => [
                'value' => $amount !== null 
                    ? $this->toCents($amount) 
                    : $orderResponse['data']['charges'][0]['amount']['value'],
            ],
        ];

        $response = $this->request('POST', "/charges/{$chargeId}/cancel", $payload);
        
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
        return $this->refund($externalId);
    }

    /**
     * Map PagSeguro status to internal status
     *
     * @param string $status
     * @return string
     */
    protected function mapStatus(string $status): string
    {
        return match ($status) {
            'PAID', 'AUTHORIZED' => 'approved',
            'WAITING' => 'pending',
            'IN_ANALYSIS' => 'processing',
            'DECLINED' => 'declined',
            'CANCELED' => 'cancelled',
            default => 'pending',
        };
    }
}
