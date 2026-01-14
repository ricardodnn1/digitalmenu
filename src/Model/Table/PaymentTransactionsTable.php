<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PaymentTransactions Model
 *
 * @property \App\Model\Table\PaymentMethodsTable&\Cake\ORM\Association\BelongsTo $PaymentMethods
 *
 * @method \App\Model\Entity\PaymentTransaction newEmptyEntity()
 * @method \App\Model\Entity\PaymentTransaction newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\PaymentTransaction> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PaymentTransaction get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\PaymentTransaction findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\PaymentTransaction patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\PaymentTransaction> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PaymentTransaction|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\PaymentTransaction saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PaymentTransactionsTable extends Table
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

        $this->setTable('payment_transactions');
        $this->setDisplayField('reference_code');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('PaymentMethods', [
            'foreignKey' => 'payment_method_id',
            'joinType' => 'INNER',
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
            ->integer('payment_method_id')
            ->notEmptyString('payment_method_id');

        $validator
            ->decimal('amount')
            ->requirePresence('amount', 'create')
            ->notEmptyString('amount');

        $validator
            ->scalar('currency')
            ->maxLength('currency', 3)
            ->notEmptyString('currency');

        $validator
            ->scalar('status')
            ->inList('status', ['pending', 'processing', 'approved', 'declined', 'refunded', 'cancelled', 'expired'])
            ->notEmptyString('status');

        return $validator;
    }

    /**
     * Returns a rules checker object
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['payment_method_id'], 'PaymentMethods'), ['errorField' => 'payment_method_id']);

        return $rules;
    }

    /**
     * Find by external ID
     *
     * @param \Cake\ORM\Query\SelectQuery $query
     * @param string $externalId
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function findByExternalId(SelectQuery $query, string $externalId): SelectQuery
    {
        return $query->where(['PaymentTransactions.external_id' => $externalId]);
    }

    /**
     * Find by status
     *
     * @param \Cake\ORM\Query\SelectQuery $query
     * @param string $status
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function findByStatus(SelectQuery $query, string $status): SelectQuery
    {
        return $query->where(['PaymentTransactions.status' => $status]);
    }

    /**
     * Generate unique reference code
     *
     * @return string
     */
    public function generateReferenceCode(): string
    {
        do {
            $code = 'PAY-' . strtoupper(bin2hex(random_bytes(6)));
        } while ($this->exists(['reference_code' => $code]));

        return $code;
    }

    /**
     * Update transaction status from webhook
     *
     * @param string $externalId
     * @param string $newStatus
     * @param array $additionalData
     * @return \App\Model\Entity\PaymentTransaction|null
     */
    public function updateFromWebhook(string $externalId, string $newStatus, array $additionalData = []): ?\App\Model\Entity\PaymentTransaction
    {
        $transaction = $this->find()
            ->where(['external_id' => $externalId])
            ->first();

        if (!$transaction) {
            return null;
        }

        $transaction->status = $newStatus;
        
        if ($newStatus === 'approved' && empty($transaction->paid_at)) {
            $transaction->paid_at = new \Cake\I18n\DateTime();
        }
        
        if ($newStatus === 'refunded' && empty($transaction->refunded_at)) {
            $transaction->refunded_at = new \Cake\I18n\DateTime();
        }

        foreach ($additionalData as $key => $value) {
            if ($transaction->isAccessible($key)) {
                $transaction->set($key, $value);
            }
        }

        return $this->save($transaction) ?: null;
    }
}
