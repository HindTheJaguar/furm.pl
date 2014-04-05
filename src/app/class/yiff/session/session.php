<?php
/**
 * @author Przemysław 'Hind' Jakubowski
 */
namespace yiff\session;

class session {
    
    protected $_postValue = null;
    static protected $_instance;


    public function __construct() {
        if (isset($_SESSION['_postValue'])) {
            $this->_postValue = $_SESSION['_postValue'];
            unset($_SESSION['_postValue']);
        }
    }
    
    /**
     * Zwraca id zalogowanej osoby
     * @return int
     */
    public function getUserId() {
        return $this->get('_UserId');
    }
    
    /**
     * Usuwa dane sesji
     */
    public function destroy() {
        $_SESSION = array();
    }
    
    public function get($name) {
        if ( isset($_SESSION[$name]))
        return $_SESSION[$name];
        return null;
    }
    
    public function set($name,$value) {
        return $_SESSION[$name] = $value;
    }
    
    public function setUid($uid) {
        $this->set('_UserId',$uid);
    }
    
    public function getUid() {
        return $this->getUserId();
    }

    public function setLifetime() {
        
    }

    static public function unserialize($data) {
        ;
    }
    
    public function __get($name) {
        return $this->get($name);
    }
    
    public function __set($name, $value) {
        $this->set($name, $value);
    }
    
    public function setPostValue($postValue) {
        $this->set('_postValue',$postValue);
    }
    
    public function getPostValue() {
        return $this->_postValue;
    }
    
    public function isPostValue() {
        return (bool) $this->_postValue;
    }
}

