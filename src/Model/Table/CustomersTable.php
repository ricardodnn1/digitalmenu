<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\RulesChecker;

/**
 * Customers Model
 *
 * @property \App\Model\Table\CustomerAddressesTable&\Cake\ORM\Association\HasMany $CustomerAddresses
 *
 * @method \App\Model\Entity\Customer newEmptyEntity()
 * @method \App\Model\Entity\Customer newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Customer get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Customer findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Customer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Customer|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CustomersTable extends Table
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

        $this->setTable('customers');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('CustomerAddresses', [
            'foreignKey' => 'customer_id',
            'dependent' => true,
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
            ->maxLength('name', 150)
            ->requirePresence('name', 'create')
            ->notEmptyString('name', 'Por favor, informe seu nome');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email', 'Por favor, informe seu e-mail');

        $validator
            ->scalar('password')
            ->minLength('password', 6, 'A senha deve ter pelo menos 6 caracteres')
            ->requirePresence('password', 'create')
            ->notEmptyString('password', 'Por favor, informe uma senha');

        $validator
            ->scalar('phone')
            ->maxLength('phone', 20)
            ->allowEmptyString('phone');

        $validator
            ->scalar('cpf')
            ->maxLength('cpf', 14)
            ->allowEmptyString('cpf');

        return $validator;
    }

    /**
     * Validation for registration
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationRegister(Validator $validator): Validator
    {
        $validator = $this->validationDefault($validator);
        
        $validator
            ->scalar('password_confirm')
            ->requirePresence('password_confirm', 'create')
            ->notEmptyString('password_confirm', 'Por favor, confirme sua senha')
            ->sameAs('password_confirm', 'password', 'As senhas não conferem');

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
        $rules->add($rules->isUnique(['email'], 'Este e-mail já está cadastrado'));

        return $rules;
    }

    /**
     * Find customer by email for authentication
     *
     * @param string $email
     * @return \App\Model\Entity\Customer|null
     */
    public function findByEmail(string $email): ?\App\Model\Entity\Customer
    {
        return $this->find()
            ->where(['email' => $email, 'is_active' => true])
            ->first();
    }
}
