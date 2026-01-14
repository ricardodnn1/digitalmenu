<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Restaurant Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $logo_url
 * @property string|null $qrcode_url
 * @property \Cake\I18n\DateTime $created_at
 * @property \Cake\I18n\DateTime $updated_at
 *
 * @property \App\Model\Entity\Category[] $categories
 * @property \App\Model\Entity\AdminUser[] $admin_users
 */
class Restaurant extends Entity
{
    /**
     * @var list<string>
     */
    protected array $_accessible = [
        'name' => true,
        'logo_url' => true,
        'qrcode_url' => true,
        'created_at' => true,
        'updated_at' => true,
        'categories' => true,
        'admin_users' => true,
    ];
}
