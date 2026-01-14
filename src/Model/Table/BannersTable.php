<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Banners Model
 *
 * @property \App\Model\Table\RestaurantsTable&\Cake\ORM\Association\BelongsTo $Restaurants
 *
 * @method \App\Model\Entity\Banner newEmptyEntity()
 * @method \App\Model\Entity\Banner newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Banner> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Banner get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Banner findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Banner patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Banner> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Banner|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Banner saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 */
class BannersTable extends Table
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

        $this->setTable('banners');
        $this->setDisplayField('title');
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
            ->scalar('title')
            ->maxLength('title', 255)
            ->allowEmptyString('title');

        $validator
            ->scalar('image_url')
            ->maxLength('image_url', 500)
            ->requirePresence('image_url', 'create')
            ->notEmptyString('image_url', 'A URL da imagem é obrigatória');

        $validator
            ->scalar('link_url')
            ->maxLength('link_url', 500)
            ->allowEmptyString('link_url');

        $validator
            ->integer('position')
            ->allowEmptyString('position');

        $validator
            ->boolean('is_active')
            ->allowEmptyString('is_active');

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
     * Busca banners ativos por restaurante
     *
     * @param int $restaurantId
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function findActiveByRestaurant(int $restaurantId): SelectQuery
    {
        return $this->find()
            ->where([
                'restaurant_id' => $restaurantId,
                'is_active' => true,
            ])
            ->orderBy(['position' => 'ASC']);
    }

    /**
     * Busca todos os banners de um restaurante
     *
     * @param int $restaurantId
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function findByRestaurant(int $restaurantId): SelectQuery
    {
        return $this->find()
            ->where(['restaurant_id' => $restaurantId])
            ->orderBy(['position' => 'ASC']);
    }
}
