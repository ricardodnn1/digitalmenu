<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OpeningHour Entity
 *
 * @property int $id
 * @property int $restaurant_id
 * @property int $day_of_week
 * @property \Cake\I18n\Time|null $open_time
 * @property \Cake\I18n\Time|null $close_time
 * @property bool $is_closed
 * @property \Cake\I18n\DateTime $created_at
 * @property \Cake\I18n\DateTime $updated_at
 *
 * @property \App\Model\Entity\Restaurant $restaurant
 */
class OpeningHour extends Entity
{
    /**
     * Dias da semana em português
     */
    public const DAYS_OF_WEEK = [
        0 => 'Domingo',
        1 => 'Segunda-feira',
        2 => 'Terça-feira',
        3 => 'Quarta-feira',
        4 => 'Quinta-feira',
        5 => 'Sexta-feira',
        6 => 'Sábado',
    ];

    /**
     * Dias da semana abreviados
     */
    public const DAYS_SHORT = [
        0 => 'Dom',
        1 => 'Seg',
        2 => 'Ter',
        3 => 'Qua',
        4 => 'Qui',
        5 => 'Sex',
        6 => 'Sáb',
    ];

    /**
     * @var list<string>
     */
    protected array $_accessible = [
        'restaurant_id' => true,
        'day_of_week' => true,
        'open_time' => true,
        'close_time' => true,
        'is_closed' => true,
        'created_at' => true,
        'updated_at' => true,
        'restaurant' => true,
    ];

    /**
     * Retorna o nome do dia da semana
     *
     * @return string
     */
    protected function _getDayName(): string
    {
        return self::DAYS_OF_WEEK[$this->day_of_week] ?? '';
    }

    /**
     * Retorna o nome abreviado do dia
     *
     * @return string
     */
    protected function _getDayShort(): string
    {
        return self::DAYS_SHORT[$this->day_of_week] ?? '';
    }
}
