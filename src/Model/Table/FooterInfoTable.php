<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FooterInfo Model
 *
 * @property \App\Model\Table\RestaurantsTable&\Cake\ORM\Association\BelongsTo $Restaurants
 *
 * @method \App\Model\Entity\FooterInfo newEmptyEntity()
 * @method \App\Model\Entity\FooterInfo newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\FooterInfo> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FooterInfo get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\FooterInfo findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\FooterInfo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\FooterInfo> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\FooterInfo|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\FooterInfo saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 */
class FooterInfoTable extends Table
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

        $this->setTable('footer_info');
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
            ->scalar('address')
            ->maxLength('address', 500)
            ->allowEmptyString('address');

        $validator
            ->scalar('phone')
            ->maxLength('phone', 50)
            ->allowEmptyString('phone');

        $validator
            ->email('email')
            ->maxLength('email', 255)
            ->allowEmptyString('email');

        $validator
            ->scalar('whatsapp')
            ->maxLength('whatsapp', 50)
            ->allowEmptyString('whatsapp');

        $validator
            ->scalar('instagram_url')
            ->maxLength('instagram_url', 500)
            ->allowEmptyString('instagram_url');

        $validator
            ->scalar('facebook_url')
            ->maxLength('facebook_url', 500)
            ->allowEmptyString('facebook_url');

        $validator
            ->scalar('twitter_url')
            ->maxLength('twitter_url', 500)
            ->allowEmptyString('twitter_url');

        $validator
            ->scalar('tiktok_url')
            ->maxLength('tiktok_url', 500)
            ->allowEmptyString('tiktok_url');

        $validator
            ->scalar('copyright_text')
            ->maxLength('copyright_text', 255)
            ->allowEmptyString('copyright_text');

        $validator
            ->scalar('additional_info')
            ->allowEmptyString('additional_info');

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
     * Busca informações do footer por restaurante
     *
     * @param int $restaurantId
     * @return \App\Model\Entity\FooterInfo|null
     */
    public function getByRestaurant(int $restaurantId): ?\App\Model\Entity\FooterInfo
    {
        return $this->find()
            ->where(['restaurant_id' => $restaurantId])
            ->first();
    }

    /**
     * Busca ou cria informações do footer para um restaurante
     *
     * @param int $restaurantId
     * @return \App\Model\Entity\FooterInfo
     */
    public function getOrCreateForRestaurant(int $restaurantId): \App\Model\Entity\FooterInfo
    {
        $footerInfo = $this->getByRestaurant($restaurantId);

        if (!$footerInfo) {
            $footerInfo = $this->newEntity([
                'restaurant_id' => $restaurantId,
                'copyright_text' => '© ' . date('Y') . ' - Todos os direitos reservados',
            ]);
            $this->save($footerInfo);
        }

        return $footerInfo;
    }
}
