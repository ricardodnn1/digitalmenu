<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Authentication\PasswordHasher\DefaultPasswordHasher;

/**
 * Customer Entity
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $phone
 * @property string|null $cpf
 * @property string|null $address_street
 * @property string|null $address_number
 * @property string|null $address_complement
 * @property string|null $address_neighborhood
 * @property string|null $address_city
 * @property string|null $address_state
 * @property string|null $address_zipcode
 * @property bool $is_active
 * @property bool $email_verified
 * @property \Cake\I18n\DateTime|null $last_login
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\CustomerAddress[] $customer_addresses
 */
class Customer extends Entity
{
    /**
     * Fields that can be mass assigned
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'name' => true,
        'email' => true,
        'password' => true,
        'phone' => true,
        'cpf' => true,
        'address_street' => true,
        'address_number' => true,
        'address_complement' => true,
        'address_neighborhood' => true,
        'address_city' => true,
        'address_state' => true,
        'address_zipcode' => true,
        'is_active' => true,
        'email_verified' => true,
        'last_login' => true,
        'created' => false,
        'modified' => false,
        'customer_addresses' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var list<string>
     */
    protected array $_hidden = [
        'password',
    ];

    /**
     * Hashing password before saving
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

    /**
     * Get full address as string
     *
     * @return string
     */
    public function getFullAddress(): string
    {
        $parts = array_filter([
            $this->address_street,
            $this->address_number,
            $this->address_complement,
            $this->address_neighborhood,
            $this->address_city,
            $this->address_state,
            $this->address_zipcode,
        ]);
        
        return implode(', ', $parts);
    }

    /**
     * Get first name
     *
     * @return string
     */
    public function getFirstName(): string
    {
        $parts = explode(' ', $this->name);
        return $parts[0] ?? '';
    }
}
