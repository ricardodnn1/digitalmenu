<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AdminUsers Model
 *
 * @property \App\Model\Table\RestaurantsTable&\Cake\ORM\Association\BelongsTo $Restaurants
 *
 * @method \App\Model\Entity\AdminUser newEmptyEntity()
 * @method \App\Model\Entity\AdminUser newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\AdminUser> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AdminUser get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\AdminUser findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\AdminUser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\AdminUser> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\AdminUser|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\AdminUser saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\AdminUser>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AdminUser>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AdminUser>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AdminUser> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AdminUser>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AdminUser>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AdminUser>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AdminUser> deleteManyOrFail(iterable $entities, array $options = [])
 */
class AdminUsersTable extends Table
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

        $this->setTable('admin_users');
        $this->setDisplayField('username');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created_at' => 'new',
                ],
            ],
        ]);

        $this->belongsTo('Restaurants', [
            'foreignKey' => 'restaurant_id',
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
            ->scalar('username')
            ->maxLength('username', 100)
            ->requirePresence('username', 'create')
            ->notEmptyString('username')
            ->add('username', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmptyString('password');

        $validator
            ->integer('restaurant_id')
            ->notEmptyString('restaurant_id');

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
        $rules->add($rules->isUnique(['username']), ['errorField' => 'username']);
        $rules->add($rules->existsIn(['restaurant_id'], 'Restaurants'), ['errorField' => 'restaurant_id']);

        return $rules;
    }
}
