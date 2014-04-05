<?php

/**
 * System EKL
 * 
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2014-02-14, 06:03:52
 * 
 * Opis zmian:
 * 2014-02-14:
 * -Utworzenie pliku
 */

namespace meets\rooms;
use yiff\db;
/**
 * @yiff-db-table:meets_rooms
 * @property int $id id
 * @property int $name Nazwa
 * @property int $size Ilość miejsc
 * @property dateTime $created Data utworzenia
 * @property string $room_nr numer pokoju
 * @property int $user_id osoba tworząca
 * @property string $group_name nazwa grupy
 * @property int $meet_id Id Meet
 */
class rooms extends db\model\rowAbstract
{
    /**
     * 
     * @param type $user
     * @return occupants
     */
    public function join($user)
    {
        $row = occupants::model()->create([
            'room_id'=>$this->id,
            'user_id'=>  is_numeric($user)?$user:$user->id,
        ]);
        
        $row->save();
        return $row;
    }
    
    public function getOccupants()
    {
        return occupants::model()->fetchAll([
            'room_id = ?'=>$this->id
        ]);
    }
}