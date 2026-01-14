<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\Http\Response;

/**
 * PaymentMethods Controller
 *
 * @property \App\Model\Table\PaymentMethodsTable $PaymentMethods
 */
class PaymentMethodsController extends AppController
{
    /**
     * Index method - List all payment methods
     *
     * @return \Cake\Http\Response|null|void
     */
    public function index()
    {
        $paymentMethods = $this->PaymentMethods->find()
            ->orderBy(['display_order' => 'ASC'])
            ->all();

        // Get transaction stats
        $paymentTransactions = $this->fetchTable('PaymentTransactions');
        $stats = [
            'total_transactions' => $paymentTransactions->find()->count(),
            'pending' => $paymentTransactions->find()->where(['status' => 'pending'])->count(),
            'approved' => $paymentTransactions->find()->where(['status' => 'approved'])->count(),
            'total_revenue' => $paymentTransactions->find()
                ->where(['status' => 'approved'])
                ->select(['total' => $paymentTransactions->find()->func()->sum('amount')])
                ->first()
                ->total ?? 0,
        ];

        $this->set(compact('paymentMethods', 'stats'));
    }

    /**
     * View method - View payment method details
     *
     * @param string|null $id Payment Method id.
     * @return \Cake\Http\Response|null|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException
     */
    public function view(?string $id = null)
    {
        $paymentMethod = $this->PaymentMethods->get($id, contain: ['PaymentTransactions', 'WebhookLogs']);

        // Recent transactions
        $recentTransactions = $this->fetchTable('PaymentTransactions')->find()
            ->where(['payment_method_id' => $id])
            ->orderBy(['created' => 'DESC'])
            ->limit(10)
            ->all();

        // Recent webhooks
        $recentWebhooks = $this->fetchTable('WebhookLogs')->find()
            ->where(['payment_method_id' => $id])
            ->orderBy(['created' => 'DESC'])
            ->limit(10)
            ->all();

        $this->set(compact('paymentMethod', 'recentTransactions', 'recentWebhooks'));
    }

    /**
     * Add method - Add new payment method
     *
     * @return \Cake\Http\Response|null|void
     */
    public function add()
    {
        $paymentMethod = $this->PaymentMethods->newEmptyEntity();
        
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            // Handle supported methods as array
            if (isset($data['supported_methods']) && is_array($data['supported_methods'])) {
                $data['supported_methods'] = array_values(array_filter($data['supported_methods']));
            }
            
            $paymentMethod = $this->PaymentMethods->patchEntity($paymentMethod, $data);
            
            if ($this->PaymentMethods->save($paymentMethod)) {
                $this->Flash->success(__('Método de pagamento salvo com sucesso.'));
                return $this->redirect(['action' => 'configure', $paymentMethod->id]);
            }
            
            $this->Flash->error(__('Não foi possível salvar o método de pagamento. Tente novamente.'));
        }

        $providers = \App\Model\Entity\PaymentMethod::PROVIDERS;
        $paymentTypes = \App\Model\Entity\PaymentMethod::PAYMENT_TYPES;
        
        $this->set(compact('paymentMethod', 'providers', 'paymentTypes'));
    }

    /**
     * Configure method - Configure payment gateway
     *
     * @param string|null $id Payment Method id.
     * @return \Cake\Http\Response|null|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException
     */
    public function configure(?string $id = null)
    {
        $paymentMethod = $this->PaymentMethods->get($id);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            
            // Handle additional config as JSON
            if (isset($data['additional_config']) && is_array($data['additional_config'])) {
                $data['additional_config'] = array_filter($data['additional_config'], fn($v) => $v !== '');
            }
            
            // Handle supported methods as array
            if (isset($data['supported_methods']) && is_array($data['supported_methods'])) {
                $data['supported_methods'] = array_values(array_filter($data['supported_methods']));
            }
            
            $paymentMethod = $this->PaymentMethods->patchEntity($paymentMethod, $data);
            
            if ($this->PaymentMethods->save($paymentMethod)) {
                $this->Flash->success(__('Configurações salvas com sucesso.'));
                return $this->redirect(['action' => 'configure', $id]);
            }
            
            $this->Flash->error(__('Não foi possível salvar as configurações. Tente novamente.'));
        }

        // Generate webhook URL if not exists
        $baseUrl = $this->request->scheme() . '://' . $this->request->host();
        if (empty($paymentMethod->webhook_url)) {
            $this->PaymentMethods->generateWebhookUrl($paymentMethod, $baseUrl);
            $paymentMethod = $this->PaymentMethods->get($id);
        }

        $providers = \App\Model\Entity\PaymentMethod::PROVIDERS;
        $paymentTypes = \App\Model\Entity\PaymentMethod::PAYMENT_TYPES;
        
        $this->set(compact('paymentMethod', 'providers', 'paymentTypes', 'baseUrl'));
    }

    /**
     * Toggle active status
     *
     * @param string|null $id Payment Method id.
     * @return \Cake\Http\Response|null
     */
    public function toggle(?string $id = null): ?Response
    {
        $this->request->allowMethod(['post']);
        
        $paymentMethod = $this->PaymentMethods->get($id);
        $paymentMethod->is_active = !$paymentMethod->is_active;
        
        if ($this->PaymentMethods->save($paymentMethod)) {
            $status = $paymentMethod->is_active ? 'ativado' : 'desativado';
            $this->Flash->success(__('Método de pagamento {0}.', $status));
        } else {
            $this->Flash->error(__('Não foi possível alterar o status.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Set as default payment method
     *
     * @param string|null $id Payment Method id.
     * @return \Cake\Http\Response|null
     */
    public function setDefault(?string $id = null): ?Response
    {
        $this->request->allowMethod(['post']);
        
        if ($this->PaymentMethods->setAsDefault((int)$id)) {
            $this->Flash->success(__('Método de pagamento definido como padrão.'));
        } else {
            $this->Flash->error(__('Não foi possível definir como padrão.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Test connection with payment gateway
     *
     * @param string|null $id Payment Method id.
     * @return \Cake\Http\Response|null
     */
    public function testConnection(?string $id = null): ?Response
    {
        $this->request->allowMethod(['post']);
        
        $paymentMethod = $this->PaymentMethods->get($id);
        
        try {
            $service = $this->getPaymentService($paymentMethod);
            $result = $service->testConnection();
            
            if ($result['success']) {
                $this->Flash->success(__('Conexão estabelecida com sucesso! {0}', $result['message'] ?? ''));
            } else {
                $this->Flash->error(__('Falha na conexão: {0}', $result['message'] ?? 'Erro desconhecido'));
            }
        } catch (\Exception $e) {
            $this->Flash->error(__('Erro ao testar conexão: {0}', $e->getMessage()));
        }

        return $this->redirect(['action' => 'configure', $id]);
    }

    /**
     * Regenerate webhook URL
     *
     * @param string|null $id Payment Method id.
     * @return \Cake\Http\Response|null
     */
    public function regenerateWebhook(?string $id = null): ?Response
    {
        $this->request->allowMethod(['post']);
        
        $paymentMethod = $this->PaymentMethods->get($id);
        $baseUrl = $this->request->scheme() . '://' . $this->request->host();
        
        $this->PaymentMethods->generateWebhookUrl($paymentMethod, $baseUrl);
        
        $this->Flash->success(__('URL do Webhook regenerada. Atualize no painel do provedor.'));

        return $this->redirect(['action' => 'configure', $id]);
    }

    /**
     * Delete method
     *
     * @param string|null $id Payment Method id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException
     */
    public function delete(?string $id = null): ?Response
    {
        $this->request->allowMethod(['post', 'delete']);
        
        $paymentMethod = $this->PaymentMethods->get($id);
        
        // Check if has transactions
        $transactionCount = $this->fetchTable('PaymentTransactions')->find()
            ->where(['payment_method_id' => $id])
            ->count();
        
        if ($transactionCount > 0) {
            $this->Flash->error(__('Não é possível excluir um método de pagamento com transações associadas.'));
            return $this->redirect(['action' => 'index']);
        }
        
        if ($this->PaymentMethods->delete($paymentMethod)) {
            $this->Flash->success(__('Método de pagamento excluído.'));
        } else {
            $this->Flash->error(__('Não foi possível excluir o método de pagamento.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Transactions list
     *
     * @return \Cake\Http\Response|null|void
     */
    public function transactions()
    {
        $paymentTransactions = $this->fetchTable('PaymentTransactions');
        $query = $paymentTransactions->find()
            ->contain(['PaymentMethods'])
            ->orderBy(['PaymentTransactions.created' => 'DESC']);

        // Apply filters
        $status = $this->request->getQuery('status');
        if ($status) {
            $query->where(['PaymentTransactions.status' => $status]);
        }

        $paymentMethodId = $this->request->getQuery('payment_method_id');
        if ($paymentMethodId) {
            $query->where(['PaymentTransactions.payment_method_id' => $paymentMethodId]);
        }

        $transactions = $this->paginate($query, ['limit' => 25]);
        $paymentMethods = $this->PaymentMethods->find('list')->toArray();
        $statuses = \App\Model\Entity\PaymentTransaction::STATUS_LABELS;

        $this->set(compact('transactions', 'paymentMethods', 'statuses'));
    }

    /**
     * Webhook logs list
     *
     * @return \Cake\Http\Response|null|void
     */
    public function webhooks()
    {
        $webhookLogs = $this->fetchTable('WebhookLogs');
        $query = $webhookLogs->find()
            ->contain(['PaymentMethods'])
            ->orderBy(['WebhookLogs.created' => 'DESC']);

        // Apply filters
        $provider = $this->request->getQuery('provider');
        if ($provider) {
            $query->where(['WebhookLogs.provider' => $provider]);
        }

        $processed = $this->request->getQuery('processed');
        if ($processed !== null && $processed !== '') {
            $query->where(['WebhookLogs.processed' => (bool)$processed]);
        }

        $webhooks = $this->paginate($query, ['limit' => 25]);
        $providers = \App\Model\Entity\PaymentMethod::PROVIDERS;

        $this->set(compact('webhooks', 'providers'));
    }

    /**
     * Get payment service instance
     *
     * @param \App\Model\Entity\PaymentMethod $paymentMethod
     * @return \App\Service\Payment\PaymentGatewayInterface
     */
    protected function getPaymentService(\App\Model\Entity\PaymentMethod $paymentMethod): \App\Service\Payment\PaymentGatewayInterface
    {
        $serviceClass = match ($paymentMethod->provider) {
            'pagarme' => \App\Service\Payment\PagarmeService::class,
            'pagseguro' => \App\Service\Payment\PagSeguroService::class,
            'stripe' => \App\Service\Payment\StripeService::class,
            default => throw new \InvalidArgumentException("Provider não suportado: {$paymentMethod->provider}"),
        };

        return new $serviceClass($paymentMethod);
    }
}
