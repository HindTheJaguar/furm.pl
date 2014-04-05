<?php

/**
 * System EKL
 * 
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2014-02-12, 15:45:01
 * 
 * Opis zmian:
 * 2014-02-12:
 * -Utworzenie pliku
 */

namespace yiff\stdlib;

class Service
{

    protected static $container = [];

    public static function get($name)
    {
        if (Registry::check($name)) {
            return Registry::get($name);
        }
        
        if (isset(self::$container[$name])) {
            return self::$container[$name];
        }

        $class = new $name;
        Registry::set($name, $class);
        return $class;
    }
    
    public static function setContainer($container)
    {
        self::$container = $container;
    }
    
    public function getContainer()
    {
        return self::$container;
    }

}
