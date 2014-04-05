<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 */

namespace yiff\router;

class frontController
{

    protected static $instance;
    protected $_url;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function setRouteMap($map)
    {
        $this->_map = $map;
    }

    public function setUrl($url)
    {
        $this->_url = $url;
    }

    public function getRequest()
    {
        return $this->decode_url($this->_url);
    }

    public function decode_url($url)
    {
        if (!$this->_map) {
            die('brak routera');
        }
        $url = new \yiff\router\http\routeUrl($url);
        return $this->_map->match($url);
    }

}
