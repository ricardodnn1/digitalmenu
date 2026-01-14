<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * AdminUser Entity
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property int $restaurant_id
 * @property \Cake\I18n\DateTime $created_at
 *
 * @property \App\Model\Entity\Restaurant $restaurant
 */
class AdminUser extends Entity
{
    /**
     * @var list<string>
     */
    protected array $_accessible = [
        'username' => true,
        'password' => true,
        'restaurant_id' => true,
        'created_at' => true,
        'restaurant' => true,
    ];

    /**
     * @var list<string>
     */
    protected array $_hidden = [
        'password',
    ];

    /**
     * Automatically hash password when setting
     *
     * @param string $password Password to hash
     * @return string|null
     */
    protected function _setPassword(string $password): ?string
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }
        return null;
    }
}
