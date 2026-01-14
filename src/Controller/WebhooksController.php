<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;
use Cake\Log\Log;

/**
 * Webhooks Controller
 * 
 * Handles payment gateway webhook callbacks
 *
 * @property \App\Model\Table\PaymentMethodsTable $PaymentMethods
 * @property \App\Model\Table\PaymentTransactionsTable $PaymentTransactions
 * @property \App\Model\Table\WebhookLogsTable $WebhookLogs
 */
class WebhooksController extends AppController
{
    /**
     * Initialize controller
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        
        $this->loadModel('PaymentMethods');
        $this->loadModel('PaymentTransactions');
        $this->loadModel('WebhookLogs');
    }

    /**
     * Pagar.me webhook handler
     *
     * @param string|null $token Webhook secret token
     * @return \Cake\Http\Response
     */
    public function pagarme(?string $token = null): Response
    {
        return $this->handleWebhook('pagarme', $token);
    }

    /**
     * PagSeguro webhook handler
     *
     * @param string|null $token Webhook secret token
     * @return \Cake\Http\Response
     */
    public function pagseguro(?string $token = null): Response
    {
        return $this->handleWebhook('pagseguro', $token);
    }

    /**
     * Stripe webhook handler
     *
     * @param string|null $token Webhook secret token
     * @return \Cake\Http\Response
     */
    public function stripe(?string $token = null): Response
    {
        return $this->handleWebhook('stripe', $token);
    }

    /**
     * Generic webhook handler
     *
     * @param string $provider Provider name
     * @param string|null $token Webhook secret token
     * @return \Cake\Http\Response
     */
    protected function handleWebhook(string $provider, ?string $token = null): Response
    {
        $this->request->allowMethod(['post']);
        $this->autoRender = false;

        // Get payload
        $payload = $this->getPayload();
        $headers = $this->getHeaders();
        $signature = $this->getSignature($provider);
        $ipAddress = $this->request->clientIp();

        // Find payment method by token
        $paymentMethod = null;
        $signatureValid = null;

        if ($token) {
            $paymentMethod = $this->PaymentMethods->find()
                ->where([
                    'provider' => $provider,
                    'webhook_secret' => $token,
                ])
                ->first();

            $signatureValid = $paymentMethod !== null;
        }

        // Determine event type based on provider
        $eventType = $this->getEventType($provider, $payload);
        $externalId = $this->getExternalId($provider, $payload);

        // Log the webhook
        $webhookLog = $this->WebhookLogs->logWebhook($provider, $eventType, $payload, [
            'external_id' => $externalId,
            'headers' => $headers,
            'signature' => $signature,
            'signature_valid' => $signatureValid,
            'ip_address' => $ipAddress,
            'payment_method_id' => $paymentMethod?->id,
        ]);

        // Process the webhook if valid
        if ($paymentMethod && $signatureValid) {
            try {
                $this->processWebhook($provider, $eventType, $payload, $paymentMethod);
                $webhookLog->markProcessed();
                $this->WebhookLogs->save($webhookLog);

                Log::info("Webhook processed successfully: {$provider} - {$eventType}");
                
                return $this->response
                    ->withStatus(200)
                    ->withType('application/json')
                    ->withStringBody(json_encode(['status' => 'success']));
                    
            } catch (\Exception $e) {
                $webhookLog->markProcessed($e->getMessage());
                $this->WebhookLogs->save($webhookLog);

                Log::error("Webhook processing error: {$e->getMessage()}");
                
                return $this->response
                    ->withStatus(500)
                    ->withType('application/json')
                    ->withStringBody(json_encode(['status' => 'error', 'message' => $e->getMessage()]));
            }
        }

        // Invalid token or not found
        if (!$signatureValid) {
            Log::warning("Invalid webhook token for provider: {$provider}");
            
            return $this->response
                ->withStatus(401)
                ->withType('application/json')
                ->withStringBody(json_encode(['status' => 'unauthorized']));
        }

        return $this->response
            ->withStatus(200)
            ->withType('application/json')
            ->withStringBody(json_encode(['status' => 'received']));
    }

    /**
     * Get request payload
     *
     * @return array
     */
    protected function getPayload(): array
    {
        $contentType = $this->request->getHeaderLine('Content-Type');
        
        if (str_contains($contentType, 'application/json')) {
            $body = (string)$this->request->getBody();
            return json_decode($body, true) ?? [];
        }
        
        return $this->request->getData() ?: [];
    }

    /**
     * Get request headers
     *
     * @return array
     */
    protected function getHeaders(): array
    {
        $headers = [];
        $relevantHeaders = [
            'Content-Type',
            'User-Agent',
            'X-Hub-Signature',
            'X-Signature',
            'Stripe-Signature',
            'X-PagSeguro-Signature',
        ];

        foreach ($relevantHeaders as $header) {
            $value = $this->request->getHeaderLine($header);
            if ($value) {
                $headers[$header] = $value;
            }
        }

        return $headers;
    }

    /**
     * Get signature based on provider
     *
     * @param string $provider
     * @return string|null
     */
    protected function getSignature(string $provider): ?string
    {
        return match ($provider) {
            'pagarme' => $this->request->getHeaderLine('X-Hub-Signature'),
            'pagseguro' => $this->request->getHeaderLine('X-PagSeguro-Signature'),
            'stripe' => $this->request->getHeaderLine('Stripe-Signature'),
            default => null,
        };
    }

    /**
     * Get event type from payload
     *
     * @param string $provider
     * @param array $payload
     * @return string
     */
    protected function getEventType(string $provider, array $payload): string
    {
        return match ($provider) {
            'pagarme' => $payload['type'] ?? $payload['event'] ?? 'unknown',
            'pagseguro' => $payload['notificationType'] ?? $payload['event_type'] ?? 'unknown',
            'stripe' => $payload['type'] ?? 'unknown',
            default => 'unknown',
        };
    }

    /**
     * Get external ID from payload
     *
     * @param string $provider
     * @param array $payload
     * @return string|null
     */
    protected function getExternalId(string $provider, array $payload): ?string
    {
        return match ($provider) {
            'pagarme' => $payload['data']['id'] ?? $payload['id'] ?? null,
            'pagseguro' => $payload['notificationCode'] ?? $payload['id'] ?? null,
            'stripe' => $payload['data']['object']['id'] ?? $payload['id'] ?? null,
            default => null,
        };
    }

    /**
     * Process webhook based on provider
     *
     * @param string $provider
     * @param string $eventType
     * @param array $payload
     * @param \App\Model\Entity\PaymentMethod $paymentMethod
     * @return void
     */
    protected function processWebhook(
        string $provider,
        string $eventType,
        array $payload,
        \App\Model\Entity\PaymentMethod $paymentMethod
    ): void {
        $statusMap = $this->getStatusMap($provider);
        
        $externalId = $this->getExternalId($provider, $payload);
        
        if (!$externalId) {
            return;
        }

        // Determine new status
        $newStatus = $this->mapEventToStatus($provider, $eventType, $payload);
        
        if (!$newStatus) {
            return;
        }

        // Update transaction
        $additionalData = $this->extractAdditionalData($provider, $payload);
        
        $this->PaymentTransactions->updateFromWebhook($externalId, $newStatus, $additionalData);
    }

    /**
     * Map event type to transaction status
     *
     * @param string $provider
     * @param string $eventType
     * @param array $payload
     * @return string|null
     */
    protected function mapEventToStatus(string $provider, string $eventType, array $payload): ?string
    {
        // Pagar.me status mapping
        if ($provider === 'pagarme') {
            $pagarmeMap = [
                'charge.paid' => 'approved',
                'charge.payment_failed' => 'declined',
                'charge.refunded' => 'refunded',
                'charge.pending' => 'pending',
                'charge.processing' => 'processing',
                'charge.canceled' => 'cancelled',
                'charge.expired' => 'expired',
            ];
            return $pagarmeMap[$eventType] ?? null;
        }

        // PagSeguro status mapping
        if ($provider === 'pagseguro') {
            $pagseguroMap = [
                'PAID' => 'approved',
                'AUTHORIZED' => 'approved',
                'DECLINED' => 'declined',
                'CANCELED' => 'cancelled',
                'IN_ANALYSIS' => 'processing',
                'WAITING' => 'pending',
            ];
            
            $status = $payload['charges'][0]['status'] ?? $payload['status'] ?? null;
            return $pagseguroMap[$status] ?? null;
        }

        // Stripe status mapping
        if ($provider === 'stripe') {
            $stripeMap = [
                'payment_intent.succeeded' => 'approved',
                'payment_intent.payment_failed' => 'declined',
                'charge.refunded' => 'refunded',
                'payment_intent.canceled' => 'cancelled',
                'payment_intent.processing' => 'processing',
                'payment_intent.created' => 'pending',
            ];
            return $stripeMap[$eventType] ?? null;
        }

        return null;
    }

    /**
     * Extract additional data from payload
     *
     * @param string $provider
     * @param array $payload
     * @return array
     */
    protected function extractAdditionalData(string $provider, array $payload): array
    {
        $data = [
            'provider_response' => $payload,
        ];

        if ($provider === 'pagarme') {
            $charge = $payload['data'] ?? $payload;
            $data['card_last_digits'] = $charge['last_four_digits'] ?? null;
            $data['card_brand'] = $charge['brand'] ?? null;
        }

        if ($provider === 'stripe') {
            $object = $payload['data']['object'] ?? [];
            $data['card_last_digits'] = $object['payment_method_details']['card']['last4'] ?? null;
            $data['card_brand'] = $object['payment_method_details']['card']['brand'] ?? null;
        }

        return array_filter($data);
    }

    /**
     * Get status mapping for provider
     *
     * @param string $provider
     * @return array
     */
    protected function getStatusMap(string $provider): array
    {
        return match ($provider) {
            'pagarme' => [
                'paid' => 'approved',
                'pending' => 'pending',
                'failed' => 'declined',
                'refunded' => 'refunded',
                'canceled' => 'cancelled',
            ],
            'pagseguro' => [
                'PAID' => 'approved',
                'AUTHORIZED' => 'approved',
                'DECLINED' => 'declined',
                'CANCELED' => 'cancelled',
            ],
            'stripe' => [
                'succeeded' => 'approved',
                'pending' => 'pending',
                'failed' => 'declined',
                'canceled' => 'cancelled',
            ],
            default => [],
        };
    }
}
