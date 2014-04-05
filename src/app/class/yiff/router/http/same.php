<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2013-05-12, 21:35:53
 */

namespace yiff\router\http;

class same extends routeAbstract {

    public $_config = [];

    public function __construct($config) {
        $this->_config = $config;
        $this->_req = $config['req'];
    }

    public function match($url) {
        if ($url->url == $this->_config['url']) {
            return true;
        }
    }

}
