<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Banner Entity
 *
 * @property int $id
 * @property int $restaurant_id
 * @property string|null $title
 * @property string $image_url
 * @property string|null $link_url
 * @property int $position
 * @property bool $is_active
 * @property \Cake\I18n\DateTime $created_at
 * @property \Cake\I18n\DateTime $updated_at
 *
 * @property \App\Model\Entity\Restaurant $restaurant
 */
class Banner extends Entity
{
    /**
     * @var list<string>
     */
    protected array $_accessible = [
        'restaurant_id' => true,
        'title' => true,
        'image_url' => true,
        'link_url' => true,
        'position' => true,
        'is_active' => true,
        'created_at' => true,
        'updated_at' => true,
        'restaurant' => true,
    ];
}
