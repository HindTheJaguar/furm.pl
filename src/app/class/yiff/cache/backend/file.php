<?php

/**
 * System EKL
 * 
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2014-01-26, 18:36:06
 * 
 * 2014-01-26:
 * -Utworzenie pliku
 */

namespace yiff\cache\backend;

/**
 * Description of file
 *
 */
class file
{

    public static $dir = '/temp';
    public static function fetch($key, &$success)
    {
        $key = md5($key);
        if (! is_file(self::$dir.'/yiff-cache_'.$key.'.dat')) {
            $success = false;
            return null;
        }
        
        $dat = file_get_contents(self::$dir.'/yiff-cache_'.$key.'.info');
        if ($dat < time()) {
            unlink(self::$dir.'/yiff-cache_'.$key.'.info');
            unlink(self::$dir.'/yiff-cache_'.$key.'.dat');
            $success = false;
            return null;
        }
        
        
        $success = true;
        return unserialize(file_get_contents(self::$dir.'/yiff-cache_'.$key.'.dat'));
    }

    public static function store($key, $data, $ttl = 60)
    {
        $key = md5($key);
        file_put_contents(self::$dir.'/yiff-cache_'.$key.'.info',time()+$ttl);
        file_put_contents(self::$dir.'/yiff-cache_'.$key.'.dat',  serialize($data));
        return true;
    }

}
