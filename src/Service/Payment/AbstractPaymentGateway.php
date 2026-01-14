<?php
declare(strict_types=1);

namespace App\Service\Payment;

use App\Model\Entity\PaymentMethod;
use Cake\Http\Client;
use Cake\Log\Log;

/**
 * Abstract Payment Gateway
 * 
 * Base class for payment gateway implementations
 */
abstract class AbstractPaymentGateway implements PaymentGatewayInterface
{
    /**
     * Payment method entity
     *
     * @var PaymentMethod
     */
    protected PaymentMethod $paymentMethod;

    /**
     * HTTP Client
     *
     * @var Client
     */
    protected Client $httpClient;

    /**
     * Constructor
     *
     * @param PaymentMethod $paymentMethod
     */
    public function __construct(PaymentMethod $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
        $this->httpClient = new Client([
            'timeout' => 30,
        ]);
    }

    /**
     * Get API base URL based on environment
     *
     * @return string
     */
    abstract protected function getBaseUrl(): string;

    /**
     * Get API key (decrypted)
     *
     * @return string|null
     */
    protected function getApiKey(): ?string
    {
        return $this->paymentMethod->api_key_decrypted;
    }

    /**
     * Get API secret (decrypted)
     *
     * @return string|null
     */
    protected function getApiSecret(): ?string
    {
        return $this->paymentMethod->api_secret_decrypted;
    }

    /**
     * Check if in sandbox mode
     *
     * @return bool
     */
    protected function isSandbox(): bool
    {
        return $this->paymentMethod->isSandbox();
    }

    /**
     * Make HTTP request
     *
     * @param string $method HTTP method
     * @param string $endpoint API endpoint
     * @param array $data Request data
     * @param array $headers Additional headers
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
                'POST' => $this->httpClient->post($url, json_encode($data), ['headers' => $headers, 'type' => 'json']),
                'PUT' => $this->httpClient->put($url, json_encode($data), ['headers' => $headers, 'type' => 'json']),
                'PATCH' => $this->httpClient->patch($url, json_encode($data), ['headers' => $headers, 'type' => 'json']),
                'DELETE' => $this->httpClient->delete($url, $data, ['headers' => $headers]),
                default => throw new \InvalidArgumentException("Invalid HTTP method: {$method}"),
            };

            $body = $response->getJson() ?? [];
            
            if (!$response->isOk()) {
                Log::error("Payment API Error [{$this->paymentMethod->provider}]: " . json_encode($body));
                return [
                    'success' => false,
                    'error' => $body['message'] ?? $body['error'] ?? 'Unknown error',
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
            Log::error("Payment API Exception [{$this->paymentMethod->provider}]: " . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get default headers for API requests
     *
     * @return array
     */
    abstract protected function getDefaultHeaders(): array;

    /**
     * Format amount to cents
     *
     * @param float $amount Amount in decimal
     * @return int Amount in cents
     */
    protected function toCents(float $amount): int
    {
        return (int) round($amount * 100);
    }

    /**
     * Format amount from cents to decimal
     *
     * @param int $cents Amount in cents
     * @return float Amount in decimal
     */
    protected function fromCents(int $cents): float
    {
        return $cents / 100;
    }

    /**
     * Format document (CPF/CNPJ)
     *
     * @param string $document
     * @return string
     */
    protected function formatDocument(string $document): string
    {
        return preg_replace('/\D/', '', $document);
    }

    /**
     * Format phone number
     *
     * @param string $phone
     * @return array{country_code: string, area_code: string, number: string}
     */
    protected function formatPhone(string $phone): array
    {
        $phone = preg_replace('/\D/', '', $phone);
        
        return [
            'country_code' => '55',
            'area_code' => substr($phone, 0, 2),
            'number' => substr($phone, 2),
        ];
    }

    /**
     * Validate webhook signature (default implementation)
     *
     * @param string $payload
     * @param string $signature
     * @return bool
     */
    public function validateWebhookSignature(string $payload, string $signature): bool
    {
        // Override in specific implementations
        return true;
    }

    /**
     * Get supported payment methods
     *
     * @return array
     */
    public function getSupportedMethods(): array
    {
        return $this->paymentMethod->supported_methods ?? [];
    }
}
