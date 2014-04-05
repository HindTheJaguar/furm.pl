<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2013-05-04, 19:09:09
 */

namespace yiff\helpers;

class dump {

    public static function dump($var, $name = '') {
        echo '<pre style="border: solid 1px black; background: #DDE;">';
        var_dump($var);
        echo '</pre>';
    }

}
