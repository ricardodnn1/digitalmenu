<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\RulesChecker;

/**
 * CustomerAddresses Model
 *
 * @property \App\Model\Table\CustomersTable&\Cake\ORM\Association\BelongsTo $Customers
 *
 * @method \App\Model\Entity\CustomerAddress newEmptyEntity()
 * @method \App\Model\Entity\CustomerAddress newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\CustomerAddress get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\CustomerAddress findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\CustomerAddress patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CustomerAddress|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CustomerAddressesTable extends Table
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

        $this->setTable('customer_addresses');
        $this->setDisplayField('label');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
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
            ->integer('customer_id')
            ->notEmptyString('customer_id');

        $validator
            ->scalar('label')
            ->maxLength('label', 50)
            ->notEmptyString('label');

        $validator
            ->scalar('street')
            ->maxLength('street', 255)
            ->requirePresence('street', 'create')
            ->notEmptyString('street');

        $validator
            ->scalar('number')
            ->maxLength('number', 20)
            ->requirePresence('number', 'create')
            ->notEmptyString('number');

        $validator
            ->scalar('neighborhood')
            ->maxLength('neighborhood', 100)
            ->requirePresence('neighborhood', 'create')
            ->notEmptyString('neighborhood');

        $validator
            ->scalar('city')
            ->maxLength('city', 100)
            ->requirePresence('city', 'create')
            ->notEmptyString('city');

        $validator
            ->scalar('state')
            ->maxLength('state', 2)
            ->requirePresence('state', 'create')
            ->notEmptyString('state');

        $validator
            ->scalar('zipcode')
            ->maxLength('zipcode', 10)
            ->requirePresence('zipcode', 'create')
            ->notEmptyString('zipcode');

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
        $rules->add($rules->existsIn(['customer_id'], 'Customers'));

        return $rules;
    }
}
