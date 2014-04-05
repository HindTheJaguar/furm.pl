<?php

/**
 * System EKL
 * 
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2014-02-07, 19:56:43
 * 
 * Opis zmian:
 * 2014-02-07:
 * -Utworzenie pliku
 */

namespace home\model;

/**
 * @yiff-db-table:pw
 */
class pw extends \yiff_db_model_abstract_entity
{

    const T_NONE = 0;
    const T_DRAFT = 1;
    const T_SEND = 2;
    const T_DELETED_OWN = 4;
    const T_DELETED_RECV = 8;

    protected $_flagsMap = array(
        self::T_NONE => 'NONE',
        self::T_DRAFT => 'DRAFT',
        self::T_SEND => 'SEND',
        self::T_DELETED_OWN => 'DELETED_OWN',
        self::T_DELETED_RECV => 'DELETED_RECV',
    );

    public function setFlag($flag)
    {
        
    }

    public function getSender()
    {
        return \model_users_entity::model()->findOne($this->user_id);
    }

    public function getRecv()
    {
        return \model_users_entity::model()->findOne($this->to_user_id);
    }
    
    

}
