<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Item Entity
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string|null $description
 * @property string $price
 * @property string|null $image_url
 * @property bool|null $available
 * @property \Cake\I18n\DateTime $created_at
 * @property \Cake\I18n\DateTime $updated_at
 *
 * @property \App\Model\Entity\Category $category
 */
class Item extends Entity
{
    /**
     * @var list<string>
     */
    protected array $_accessible = [
        'category_id' => true,
        'name' => true,
        'description' => true,
        'price' => true,
        'image_url' => true,
        'available' => true,
        'created_at' => true,
        'updated_at' => true,
        'category' => true,
    ];
}
