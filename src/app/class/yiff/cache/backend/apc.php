<?php

/**
 * System EKL
 * 
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2013-10-14, 16:30:41
 * 
 * Opis zmian:
 * 2013-10-14:
 * -Utworzenie pliku
 */

namespace yiff\cache\backend;

class apc
{

    public static function fetch($key, &$success)
    {
        return apc_fetch($key, $success);
    }

    public static function store($key, $data, $ttl = 0)
    {
        return apc_store($key, $data, $ttl);
    }

}
