<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OpeningHours Model
 *
 * @property \App\Model\Table\RestaurantsTable&\Cake\ORM\Association\BelongsTo $Restaurants
 *
 * @method \App\Model\Entity\OpeningHour newEmptyEntity()
 * @method \App\Model\Entity\OpeningHour newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\OpeningHour> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OpeningHour get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\OpeningHour findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\OpeningHour patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\OpeningHour> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\OpeningHour|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\OpeningHour saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 */
class OpeningHoursTable extends Table
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

        $this->setTable('opening_hours');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created_at' => 'new',
                    'updated_at' => 'always',
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
            ->integer('restaurant_id')
            ->notEmptyString('restaurant_id');

        $validator
            ->integer('day_of_week')
            ->range('day_of_week', [0, 6], 'Dia da semana deve ser entre 0 e 6')
            ->requirePresence('day_of_week', 'create')
            ->notEmptyString('day_of_week');

        $validator
            ->time('open_time')
            ->allowEmptyTime('open_time');

        $validator
            ->time('close_time')
            ->allowEmptyTime('close_time');

        $validator
            ->boolean('is_closed')
            ->allowEmptyString('is_closed');

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

    /**
     * Busca horários por restaurante ordenados por dia
     *
     * @param int $restaurantId
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function findByRestaurant(int $restaurantId): SelectQuery
    {
        return $this->find()
            ->where(['restaurant_id' => $restaurantId])
            ->orderBy(['day_of_week' => 'ASC']);
    }

    /**
     * Inicializa horários padrão para um restaurante
     *
     * @param int $restaurantId
     * @return bool
     */
    public function initializeForRestaurant(int $restaurantId): bool
    {
        $existingDays = $this->find()
            ->where(['restaurant_id' => $restaurantId])
            ->select(['day_of_week'])
            ->all()
            ->extract('day_of_week')
            ->toArray();

        $entities = [];
        for ($day = 0; $day <= 6; $day++) {
            if (!in_array($day, $existingDays)) {
                $entities[] = $this->newEntity([
                    'restaurant_id' => $restaurantId,
                    'day_of_week' => $day,
                    'open_time' => '08:00',
                    'close_time' => '22:00',
                    'is_closed' => false,
                ]);
            }
        }

        if (!empty($entities)) {
            return (bool) $this->saveMany($entities);
        }

        return true;
    }
}
