<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-03-09
 */

namespace yiff\conf;

class factory {

    static public function fromArray($array) {
        if (is_array($array)) {
            return new conf($array);
        } else {
            return new conf(require $array);
        }
    }

}