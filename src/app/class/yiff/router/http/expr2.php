<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2013-05-12, 21:43:26
 */
namespace yiff\router\http;

class expr2 extends routeAbstract {

    public $_config = [];

    public function __construct($config) {
        
        
        $config['url2'] = $config['match'];
        $this->_config = $config;
        if(isset($this->_config['default'])) {
            $this->_req = $this->_config['default'];
        }
    }

    public function match($url) {
        if (preg_match($this->_config['url2'], $url->url, $o)) {
            array_shift($o);
            foreach($o as $k=>$v) {
                $this->_req[$k]=$v;
            }

            return true;
        }
    }

}
