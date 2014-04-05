<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-07-25, 19:57:13
 */

namespace yiff\view\helper;
class escape {
    public function escape($string) {
        return nl2br(str_replace('<', '&lt;', $string));
    }
}