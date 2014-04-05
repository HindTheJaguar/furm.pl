<?php

/**
 * System EKL
 * 
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2014-02-11, 15:41:38
 * 
 * Opis zmian:
 * 2014-02-11:
 * -Utworzenie pliku
 */

namespace yiff\view;

class actionHelper
{

    public static function call($name,$args)
    {
        $class = 'yiff\\view\\helper\\' . $name;
        $view = new $class;
        return call_user_func_array(array($view, $name), $args);
    }

}
