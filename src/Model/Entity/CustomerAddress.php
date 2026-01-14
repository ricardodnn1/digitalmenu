<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CustomerAddress Entity
 *
 * @property int $id
 * @property int $customer_id
 * @property string $label
 * @property string $street
 * @property string $number
 * @property string|null $complement
 * @property string $neighborhood
 * @property string $city
 * @property string $state
 * @property string $zipcode
 * @property bool $is_default
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Customer $customer
 */
class CustomerAddress extends Entity
{
    /**
     * Fields that can be mass assigned
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'customer_id' => true,
        'label' => true,
        'street' => true,
        'number' => true,
        'complement' => true,
        'neighborhood' => true,
        'city' => true,
        'state' => true,
        'zipcode' => true,
        'is_default' => true,
        'created' => false,
        'modified' => false,
        'customer' => true,
    ];

    /**
     * Get full address as string
     *
     * @return string
     */
    public function getFullAddress(): string
    {
        $parts = array_filter([
            $this->street,
            $this->number,
            $this->complement,
            $this->neighborhood,
            $this->city,
            $this->state,
            $this->zipcode,
        ]);
        
        return implode(', ', $parts);
    }
}
