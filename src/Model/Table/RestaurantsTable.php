<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Restaurants Model
 *
 * @property \App\Model\Table\CategoriesTable&\Cake\ORM\Association\HasMany $Categories
 * @property \App\Model\Table\AdminUsersTable&\Cake\ORM\Association\HasMany $AdminUsers
 * @property \App\Model\Table\AccessLogsTable&\Cake\ORM\Association\HasMany $AccessLogs
 *
 * @method \App\Model\Entity\Restaurant newEmptyEntity()
 * @method \App\Model\Entity\Restaurant newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Restaurant> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Restaurant get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Restaurant findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Restaurant patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Restaurant> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Restaurant|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Restaurant saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Restaurant>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Restaurant>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Restaurant>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Restaurant> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Restaurant>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Restaurant>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Restaurant>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Restaurant> deleteManyOrFail(iterable $entities, array $options = [])
 */
class RestaurantsTable extends Table
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

        $this->setTable('restaurants');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created_at' => 'new',
                    'updated_at' => 'always',
                ],
            ],
        ]);

        $this->hasMany('Categories', [
            'foreignKey' => 'restaurant_id',
        ]);
        $this->hasMany('AdminUsers', [
            'foreignKey' => 'restaurant_id',
        ]);
        $this->hasMany('AccessLogs', [
            'foreignKey' => 'restaurant_id',
        ]);
        $this->hasMany('OpeningHours', [
            'foreignKey' => 'restaurant_id',
        ]);
        $this->hasMany('Banners', [
            'foreignKey' => 'restaurant_id',
        ]);
        $this->hasOne('FooterInfo', [
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('logo_url')
            ->maxLength('logo_url', 500)
            ->allowEmptyString('logo_url');

        $validator
            ->scalar('qrcode_url')
            ->maxLength('qrcode_url', 500)
            ->allowEmptyString('qrcode_url');

        return $validator;
    }
}
