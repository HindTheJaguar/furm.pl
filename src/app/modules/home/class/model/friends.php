<?php

/**
 * System EKL
 * 
 * @author Przemysław 'Hind' Jakubowski <przemyslaw.jakubowski@pkp-cargo.eu>
 * @date 2014-05-15, 15:38:28
 * 
 * 2014-05-15:
 * -Utworzenie pliku
 */

namespace home\model;

/**
 * Description of friends
 * @yiff-db-table:friends
 * @yiff-db-model:home\model\friends\model
 */
class friends extends \yiff_db_model_abstract_entity
{

    
    public static function add($user, $friend)
    {
        return self::model()->insert([
            'user_id' => $user->id,
            'friend_id' => $friend->id,
        ]);
    }

    public static function remove($user, $friend)
    {
        return self::model()->select()
                        ->where('user_id', $user->id)
                        ->where('friend_id', $friend->id)
                        ->delete();
    }

}
