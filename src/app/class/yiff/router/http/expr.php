<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2013-05-12, 21:37:14
 */

namespace yiff\router\http;

class expr extends routeAbstract {

    public $_config = [];

    public function __construct($config) {
        $this->_config = $config;
    }

    public function match($url) {
        if (preg_match($this->_config['url'], $url->url, $o)) {
            $this->o = $o;
            return true;
        }
    }

}