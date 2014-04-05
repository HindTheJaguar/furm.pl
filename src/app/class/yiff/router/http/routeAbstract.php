<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2013-05-12, 21:39:50
 */

namespace yiff\router\http;

class routeAbstract {
    public $_conf = [];
    public $_req;
    public function __construct($conf) {
        $this->_conf = $conf;
    }
    
    public function getParams() {
        return $this->_req;
    }
}
