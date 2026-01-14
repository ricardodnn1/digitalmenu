<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AccessLogs Model
 *
 * @property \App\Model\Table\RestaurantsTable&\Cake\ORM\Association\BelongsTo $Restaurants
 *
 * @method \App\Model\Entity\AccessLog newEmptyEntity()
 * @method \App\Model\Entity\AccessLog newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\AccessLog> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AccessLog get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\AccessLog findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\AccessLog patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\AccessLog> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\AccessLog|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\AccessLog saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\AccessLog>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AccessLog>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AccessLog>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AccessLog> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AccessLog>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AccessLog>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AccessLog>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AccessLog> deleteManyOrFail(iterable $entities, array $options = [])
 */
class AccessLogsTable extends Table
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

        $this->setTable('access_logs');
        $this->setDisplayField('endpoint');
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
            ->scalar('endpoint')
            ->maxLength('endpoint', 255)
            ->requirePresence('endpoint', 'create')
            ->notEmptyString('endpoint');

        $validator
            ->scalar('method')
            ->maxLength('method', 10)
            ->requirePresence('method', 'create')
            ->notEmptyString('method');

        $validator
            ->scalar('ip_address')
            ->maxLength('ip_address', 45)
            ->requirePresence('ip_address', 'create')
            ->notEmptyString('ip_address');

        $validator
            ->scalar('user_agent')
            ->allowEmptyString('user_agent');

        $validator
            ->integer('restaurant_id')
            ->allowEmptyString('restaurant_id');

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
        $rules->add($rules->existsIn(['restaurant_id'], 'Restaurants'), ['errorField' => 'restaurant_id']);

        return $rules;
    }
}
