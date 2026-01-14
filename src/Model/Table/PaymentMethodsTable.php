<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PaymentMethods Model
 *
 * @property \App\Model\Table\PaymentTransactionsTable&\Cake\ORM\Association\HasMany $PaymentTransactions
 * @property \App\Model\Table\WebhookLogsTable&\Cake\ORM\Association\HasMany $WebhookLogs
 *
 * @method \App\Model\Entity\PaymentMethod newEmptyEntity()
 * @method \App\Model\Entity\PaymentMethod newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\PaymentMethod> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PaymentMethod get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\PaymentMethod findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\PaymentMethod patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\PaymentMethod> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PaymentMethod|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\PaymentMethod saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\PaymentMethod>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PaymentMethod>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PaymentMethod>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PaymentMethod> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PaymentMethod>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PaymentMethod>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PaymentMethod>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PaymentMethod> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PaymentMethodsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('payment_methods');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('PaymentTransactions', [
            'foreignKey' => 'payment_method_id',
        ]);

        $this->hasMany('WebhookLogs', [
            'foreignKey' => 'payment_method_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('provider')
            ->maxLength('provider', 50)
            ->requirePresence('provider', 'create')
            ->notEmptyString('provider')
            ->inList('provider', ['pagarme', 'pagseguro', 'stripe', 'pix_manual', 'cash', 'boleto_manual']);

        $validator
            ->boolean('is_active')
            ->notEmptyString('is_active');

        $validator
            ->boolean('is_default')
            ->notEmptyString('is_default');

        $validator
            ->scalar('environment')
            ->inList('environment', ['sandbox', 'production'])
            ->notEmptyString('environment');

        $validator
            ->scalar('api_key')
            ->allowEmptyString('api_key');

        $validator
            ->scalar('api_secret')
            ->allowEmptyString('api_secret');

        $validator
            ->scalar('webhook_secret')
            ->maxLength('webhook_secret', 255)
            ->allowEmptyString('webhook_secret');

        $validator
            ->scalar('webhook_url')
            ->maxLength('webhook_url', 500)
            ->allowEmptyString('webhook_url');

        $validator
            ->decimal('fee_percentage')
            ->allowEmptyString('fee_percentage');

        $validator
            ->decimal('fee_fixed')
            ->allowEmptyString('fee_fixed');

        $validator
            ->decimal('min_amount')
            ->allowEmptyString('min_amount');

        $validator
            ->decimal('max_amount')
            ->allowEmptyString('max_amount');

        $validator
            ->integer('display_order')
            ->notEmptyString('display_order');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        return $rules;
    }

    /**
     * Find active payment methods
     *
     * @param \Cake\ORM\Query\SelectQuery $query
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function findActive(SelectQuery $query): SelectQuery
    {
        return $query
            ->where(['PaymentMethods.is_active' => true])
            ->orderBy(['PaymentMethods.display_order' => 'ASC']);
    }

    /**
     * Find by provider
     *
     * @param \Cake\ORM\Query\SelectQuery $query
     * @param string $provider
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function findByProvider(SelectQuery $query, string $provider): SelectQuery
    {
        return $query->where(['PaymentMethods.provider' => $provider]);
    }

    /**
     * Get the default payment method
     *
     * @return \App\Model\Entity\PaymentMethod|null
     */
    public function getDefault(): ?\App\Model\Entity\PaymentMethod
    {
        return $this->find()
            ->where(['is_active' => true, 'is_default' => true])
            ->first();
    }

    /**
     * Set a payment method as default
     *
     * @param int $id
     * @return bool
     */
    public function setAsDefault(int $id): bool
    {
        $connection = $this->getConnection();
        
        return $connection->transactional(function () use ($id) {
            // Remove default from all
            $this->updateAll(['is_default' => false], ['1 = 1']);
            
            // Set new default
            $method = $this->get($id);
            $method->is_default = true;
            
            return (bool)$this->save($method);
        });
    }

    /**
     * Generate webhook URL for a payment method
     *
     * @param \App\Model\Entity\PaymentMethod $method
     * @param string $baseUrl
     * @return string
     */
    public function generateWebhookUrl(\App\Model\Entity\PaymentMethod $method, string $baseUrl): string
    {
        $token = bin2hex(random_bytes(16));
        $method->webhook_secret = $token;
        
        $webhookUrl = rtrim($baseUrl, '/') . '/webhooks/' . $method->provider . '/' . $token;
        $method->webhook_url = $webhookUrl;
        
        $this->save($method);
        
        return $webhookUrl;
    }
}
