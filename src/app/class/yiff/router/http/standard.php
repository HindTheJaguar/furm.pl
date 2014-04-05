<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2013-05-12, 21:38:50
 */
namespace yiff\router\http;


class standard extends routeAbstract {

    public $_c;
    public function __construct($c) {
        $this->_c = $c; // tu ma być info o modułach
    }
    
    public function match($url) {
        $mod = 'default';
        if (in_array($url->url2[0],  $this->_c['modules'])) {
            $mod = array_shift($url->url2);
        }
        $controller = array_shift($url->url2);
        $action = array_shift($url->url2);
        $this->_req = $url->url2+array(
            'action'=>$action,
            'controller'=>$controller,
            'space'=>$mod,
//            'params'=>$url->url2,
        );
        
        return true;
    }

}
