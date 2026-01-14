<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AccessLog Entity
 *
 * @property int $id
 * @property string $endpoint
 * @property string $method
 * @property string $ip_address
 * @property string|null $user_agent
 * @property int|null $restaurant_id
 * @property \Cake\I18n\DateTime $created_at
 *
 * @property \App\Model\Entity\Restaurant $restaurant
 */
class AccessLog extends Entity
{
    /**
     * @var list<string>
     */
    protected array $_accessible = [
        'endpoint' => true,
        'method' => true,
        'ip_address' => true,
        'user_agent' => true,
        'restaurant_id' => true,
        'created_at' => true,
        'restaurant' => true,
    ];
}
