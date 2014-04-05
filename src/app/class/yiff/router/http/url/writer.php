<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2013-08-26, 22:01:47
 */

namespace yiff\router\http\url;

class writer {

    /**
     * Lista ścierzek do przepisania
     * @var array
     */
    protected $_maps = [];

    public function __construct() {
        // domyślna ścierzka
        $this->_maps['default@index@index'] = function() {
                    return '/';
                };
    }

    public function addMap($addr, $map) {
        $this->_maps[$addr] = $map;
    }

    public function url($url) {
        $url2 = sprintf('%s@%s@%s', $url['_module'], $url['_controller'], $url['_action']);
        if (!isset($this->_maps[$url2])) {
            return $this->_default($url);
        }

        $maper = $this->_maps[$url2];
        if ($maper instanceof Closure) {
            return $maper($url);
        }

        if (is_string($maper)) {
            $class = new $maper;
            return $class->genUrl($url);
        }
    }

    public function _default($url) {
        $r = '/';
        if ($url['_module'] != 'default') {
            $r.=$url['_module'] . '/';
        }
        $r.=$url['_controller'] . '/';
        $r.=$url['_action'];

        unset($url['_module'], $url['_controller'], $url['_action']);

        if (!count($url)) {
            return $r;
        }

        foreach ($url as $k => $v) {
            $r.='/' . $k . '/' . $v;
        }
        return HTTP_APP_BASE.$r;
    }

}
