<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Category Entity
 *
 * @property int $id
 * @property int $restaurant_id
 * @property string $name
 * @property int|null $order_index
 * @property \Cake\I18n\DateTime $created_at
 * @property \Cake\I18n\DateTime $updated_at
 *
 * @property \App\Model\Entity\Restaurant $restaurant
 * @property \App\Model\Entity\Item[] $items
 */
class Category extends Entity
{
    /**
     * @var list<string>
     */
    protected array $_accessible = [
        'restaurant_id' => true,
        'name' => true,
        'order_index' => true,
        'created_at' => true,
        'updated_at' => true,
        'restaurant' => true,
        'items' => true,
    ];
}
