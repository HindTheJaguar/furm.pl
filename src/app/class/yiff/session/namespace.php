<?php
class yiff_session_namespace {
    protected $_name;
    public function __construct($name) {
        $this->_name = $name;
    }
    
    public function __get($name) {
        if (isset($_SESSION[$this->_name][$name])) {
            return $_SESSION[$this->_name][$name];
        }
    }
    
    public function __set($name, $value) {
        $_SESSION[$this->_name][$name] = $value;
    }
    
    public function destroy() {
        unset($_SESSION[$this->_name]);
    }

    public function reset() {
        $_SESSION[$this->_name] = array();
        
    }
    
    public function setData($d) {
        $_SESSION[$this->_name] = $d;
        return $this;
    }
    
    public function __isset($name) {
        return isset($_SESSION[$this->_name][$name]);
    }
    
    public function __unset($name) {
        if (isset($_SESSION[$this->_name][$name])) {
            unset($_SESSION[$this->_name][$name]);
        }
    }
    
    public function toArray() {
        if (isset($_SESSION[$this->_name])) {
            return $_SESSION[$this->_name];
        }
    }
    
}
