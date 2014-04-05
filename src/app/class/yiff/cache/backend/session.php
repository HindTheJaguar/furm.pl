<?php

/**
 * System EKL
 * 
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2013-10-14, 16:30:49
 * 
 * Opis zmian:
 * 2013-10-14:
 * -Utworzenie pliku
 */

namespace yiff\cache\backend;

class session
{
    protected static $cache = array();
    public static function fetch($key, &$success)
    {
        if (! isset(self::$cache[$key])) {
            $success = false;
            return;
        }
        $success = true;
        return self::$cache[$key];
    }

    public static function store($key, $data, $ttl = 0)
    {
        return self::$cache[$key] = $data;
    }

}
