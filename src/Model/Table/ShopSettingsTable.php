<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Cache\Cache;

/**
 * ShopSettings Model
 *
 * @method \App\Model\Entity\ShopSetting newEmptyEntity()
 * @method \App\Model\Entity\ShopSetting newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ShopSetting get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ShopSetting findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ShopSetting patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ShopSetting|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ShopSettingsTable extends Table
{
    /**
     * Cache key for settings
     */
    private const CACHE_KEY = 'shop_settings_all';

    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('shop_settings');
        $this->setDisplayField('setting_key');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->scalar('setting_key')
            ->maxLength('setting_key', 100)
            ->requirePresence('setting_key', 'create')
            ->notEmptyString('setting_key');

        $validator
            ->scalar('setting_value')
            ->allowEmptyString('setting_value');

        return $validator;
    }

    /**
     * Get a setting value by key
     *
     * @param string $key Setting key
     * @param mixed $default Default value if not found
     * @return mixed
     */
    public function getValue(string $key, mixed $default = null): mixed
    {
        $settings = $this->getAllSettings();
        
        if (!isset($settings[$key])) {
            return $default;
        }

        $setting = $settings[$key];
        
        return match ($setting['type']) {
            'boolean' => (bool) $setting['value'],
            'integer' => (int) $setting['value'],
            'json' => json_decode($setting['value'] ?? '{}', true),
            default => $setting['value'],
        };
    }

    /**
     * Set a setting value
     *
     * @param string $key Setting key
     * @param mixed $value Setting value
     * @return bool
     */
    public function setValue(string $key, mixed $value): bool
    {
        $setting = $this->find()
            ->where(['setting_key' => $key])
            ->first();

        if (!$setting) {
            $setting = $this->newEntity([
                'setting_key' => $key,
                'setting_type' => is_bool($value) ? 'boolean' : (is_int($value) ? 'integer' : 'string'),
            ]);
        }

        if (is_array($value)) {
            $value = json_encode($value);
            $setting->setting_type = 'json';
        } elseif (is_bool($value)) {
            $value = $value ? '1' : '0';
        }

        $setting->setting_value = (string) $value;

        $result = (bool) $this->save($setting);
        
        // Clear cache
        $this->clearCache();

        return $result;
    }

    /**
     * Get all settings as array
     *
     * @return array
     */
    public function getAllSettings(): array
    {
        $cached = Cache::read(self::CACHE_KEY, 'default');
        
        if ($cached !== null) {
            return $cached;
        }

        $settings = [];
        $results = $this->find()->all();

        foreach ($results as $setting) {
            $settings[$setting->setting_key] = [
                'value' => $setting->setting_value,
                'type' => $setting->setting_type,
                'description' => $setting->description,
            ];
        }

        Cache::write(self::CACHE_KEY, $settings, 'default');

        return $settings;
    }

    /**
     * Clear settings cache
     *
     * @return void
     */
    public function clearCache(): void
    {
        Cache::delete(self::CACHE_KEY, 'default');
    }

    /**
     * Check if online payment is enabled
     *
     * @return bool
     */
    public function isOnlinePaymentEnabled(): bool
    {
        return (bool) $this->getValue('online_payment_enabled', false);
    }

    /**
     * Get WhatsApp settings
     *
     * @return array
     */
    public function getWhatsAppSettings(): array
    {
        return [
            'number' => $this->getValue('whatsapp_number', ''),
            'header' => $this->getValue('whatsapp_message_header', 'Olá! Gostaria de fazer um pedido:'),
            'footer' => $this->getValue('whatsapp_message_footer', 'Aguardo confirmação. Obrigado!'),
        ];
    }
}
