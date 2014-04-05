<?php

/**
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2014-02-14, 06:05:28
 * 
 * Opis zmian:
 * 2014-02-14:
 * -Utworzenie pliku
 */

namespace meets\rooms;

use yiff\db;

/**
 * 
 * @yiff-db-table:meets_rooms_occupants
 * @property int $id Id wpisu
 * @property int $room_id id pokoju
 * @property dateTime $created data przyłączenia
 * @property int $user_id osoba przyłączająca się
 */
class occupants extends db\model\rowAbstract
{
    public function leave()
    {
        $this->delete();
    }
}
