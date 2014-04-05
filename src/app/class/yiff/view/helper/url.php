<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-12-12, 12:56:00
 */

namespace yiff\view\helper;
use yiff;
class url {
    public function url($params = []) {
        return yiff\stdlib\Registry::get('url_writer')->url($params);
    }
}