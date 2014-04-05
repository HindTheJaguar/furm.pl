<?php

/**
 * System EKL
 * 
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2013-11-21, 16:33:22
 * 
 * Opis zmian:
 * 2013-11-21:
 * -Utworzenie pliku
 */

namespace yiff\auth;

class User
{
    public $id;
    protected $_id;
    public $session;
    public $users;
    public $_data;

    public function __construct($conf = array())
    {
        $this->id = $this->_id = $conf['id'];
        $this->_name = $conf['name'];
        $this->_login = $conf['login'];
    }

    public function getAcl()
    {
        
    }
    
    public function isGuest() {
        return !$this->_id;
    }
    
    public function isAdmin() {
        return $this->_login == 'hind';
    }

    public function getUid()
    {
        return $this->_id;
    }
    
    /**
     * @internal Dla kompatybilności
     * @return int
     */
    public function getId() {
        return $this->_id;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function getLogin()
    {
        return $this->_login;
    }

}
