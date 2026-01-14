<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShopSetting Entity
 *
 * @property int $id
 * @property string $setting_key
 * @property string|null $setting_value
 * @property string $setting_type
 * @property string|null $description
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 */
class ShopSetting extends Entity
{
    /**
     * Fields that can be mass assigned
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'setting_key' => true,
        'setting_value' => true,
        'setting_type' => true,
        'description' => true,
        'created' => false,
        'modified' => false,
    ];

    /**
     * Get typed value
     *
     * @return mixed
     */
    protected function _getTypedValue(): mixed
    {
        return match ($this->setting_type) {
            'boolean' => (bool) $this->setting_value,
            'integer' => (int) $this->setting_value,
            'json' => json_decode($this->setting_value ?? '{}', true),
            default => $this->setting_value,
        };
    }
}
