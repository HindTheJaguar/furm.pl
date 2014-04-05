<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2013-05-07, 20:59:12
 */

namespace yiff\cache;

class cache {

    public static $backend;
    public static function fetch($key, &$success = null) {
        if(! self::$backend) {
            $success = false;
            return null;
        }
        return self::$backend->fetch($key, $success);
    }

    public static function store($key, $data, $ttl = 0) {
        if (self::$backend) {
            return self::$backend->store($key, $data, $ttl);
        }
        return false;
    }
    
    public static function setBackend($backend)
    {
        if ($backend{0} === '\\') {
            $backend = $backend;
        } else {
            $backend = 'yiff\\cache\\backend\\'.$backend;
        }
        self::$backend = new $backend;
    }

}
