<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2013-05-04, 12:57:18
 */

namespace yiff\stdlib;

class Registry {

    /**
     * @access private
     * @var array
     */
    public static $_registry = [];

    /**
     * 
     * @param string $name
     * @param mixed $value
     */
    public static function set($name, $value) {
        self::$_registry[$name] = $value;
    }

    /**
     * 
     * @param bool $name
     * @return mixed
     */
    public static function get($name) {
        if (isset(self::$_registry[$name])) {
            return self::$_registry[$name];
        }
    }
    
    /**
     * 
     * @param string $name
     * @return bool
     */
    public static function check($name) {
        return isset(self::$_registry[$name]);
    }

}