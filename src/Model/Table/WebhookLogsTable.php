<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * WebhookLogs Model
 *
 * @property \App\Model\Table\PaymentMethodsTable&\Cake\ORM\Association\BelongsTo $PaymentMethods
 *
 * @method \App\Model\Entity\WebhookLog newEmptyEntity()
 * @method \App\Model\Entity\WebhookLog newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\WebhookLog> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WebhookLog get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\WebhookLog findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\WebhookLog patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\WebhookLog> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\WebhookLog|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\WebhookLog saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WebhookLogsTable extends Table
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

        $this->setTable('webhook_logs');
        $this->setDisplayField('event_type');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                ],
            ],
        ]);

        $this->belongsTo('PaymentMethods', [
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
            ->scalar('provider')
            ->maxLength('provider', 50)
            ->requirePresence('provider', 'create')
            ->notEmptyString('provider');

        $validator
            ->scalar('event_type')
            ->maxLength('event_type', 100)
            ->requirePresence('event_type', 'create')
            ->notEmptyString('event_type');

        $validator
            ->requirePresence('payload', 'create')
            ->notEmptyString('payload');

        return $validator;
    }

    /**
     * Log a webhook request
     *
     * @param string $provider
     * @param string $eventType
     * @param array $payload
     * @param array $options
     * @return \App\Model\Entity\WebhookLog
     */
    public function logWebhook(string $provider, string $eventType, array $payload, array $options = []): \App\Model\Entity\WebhookLog
    {
        $log = $this->newEntity([
            'provider' => $provider,
            'event_type' => $eventType,
            'payload' => $payload,
            'external_id' => $options['external_id'] ?? null,
            'headers' => $options['headers'] ?? null,
            'signature' => $options['signature'] ?? null,
            'signature_valid' => $options['signature_valid'] ?? null,
            'ip_address' => $options['ip_address'] ?? null,
            'payment_method_id' => $options['payment_method_id'] ?? null,
        ]);

        $this->saveOrFail($log);

        return $log;
    }

    /**
     * Find unprocessed webhooks
     *
     * @param \Cake\ORM\Query\SelectQuery $query
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function findUnprocessed(SelectQuery $query): SelectQuery
    {
        return $query->where(['WebhookLogs.processed' => false]);
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
        return $query->where(['WebhookLogs.provider' => $provider]);
    }
}
