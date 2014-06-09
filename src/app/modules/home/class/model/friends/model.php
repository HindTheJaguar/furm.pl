<?php

/**
 * System EKL
 * 
 * @author Przemysław 'Hind' Jakubowski <przemyslaw.jakubowski@pkp-cargo.eu>
 * @date 2014-05-21, 15:33:47
 * 
 * Opis zmian:
 * 2014-05-21:
 * -Utworzenie pliku
 */
namespace home\model\friends;

class model extends \yiff_db_model_abstract
{
    protected $_sequence = false;
    protected $_name = 'friends';
    protected $_primary = ['user_id','friend_id'];
}