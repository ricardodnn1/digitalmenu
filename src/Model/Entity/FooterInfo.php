<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FooterInfo Entity
 *
 * @property int $id
 * @property int $restaurant_id
 * @property string|null $address
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $whatsapp
 * @property string|null $instagram_url
 * @property string|null $facebook_url
 * @property string|null $twitter_url
 * @property string|null $tiktok_url
 * @property string|null $copyright_text
 * @property string|null $additional_info
 * @property \Cake\I18n\DateTime $created_at
 * @property \Cake\I18n\DateTime $updated_at
 *
 * @property \App\Model\Entity\Restaurant $restaurant
 */
class FooterInfo extends Entity
{
    /**
     * @var list<string>
     */
    protected array $_accessible = [
        'restaurant_id' => true,
        'address' => true,
        'phone' => true,
        'email' => true,
        'whatsapp' => true,
        'instagram_url' => true,
        'facebook_url' => true,
        'twitter_url' => true,
        'tiktok_url' => true,
        'copyright_text' => true,
        'additional_info' => true,
        'created_at' => true,
        'updated_at' => true,
        'restaurant' => true,
    ];

    /**
     * Retorna o link formatado do WhatsApp
     *
     * @return string|null
     */
    protected function _getWhatsappLink(): ?string
    {
        if (empty($this->whatsapp)) {
            return null;
        }
        $number = preg_replace('/[^0-9]/', '', $this->whatsapp);
        return "https://wa.me/{$number}";
    }

    /**
     * Verifica se tem alguma rede social configurada
     *
     * @return bool
     */
    public function hasSocialMedia(): bool
    {
        return !empty($this->instagram_url) || 
               !empty($this->facebook_url) || 
               !empty($this->twitter_url) || 
               !empty($this->tiktok_url);
    }
}
