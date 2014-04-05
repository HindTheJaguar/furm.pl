<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2013-05-12, 21:41:04
 */
namespace yiff\router\http;


class routeUrl {

    public $url, $url2;
    public $matched;

    public function __construct($url) {
        $this->url = $url;
        $this->url2 = explode('/', $url);
        array_shift($this->url2);
    }

}
