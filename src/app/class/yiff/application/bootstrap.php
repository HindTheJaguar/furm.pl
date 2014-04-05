<?php

/**
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2013-05-04, 21:35:32
 */

namespace yiff\application;

abstract class bootstrap {

    protected $_methodList = [];

    public function __construct() {
        $reflection = new \ReflectionClass($this);
        $this->_methodList = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
    }

    public function init() {
        foreach ($this->_methodList as $method) {
            $method = $method->name;
            if (substr($method, 0, 5) === '_init') {
                $this->$method();
            }
        }
    }

    public function post() {
        foreach ($this->_methodList as $method) {
            $method = $method->name;
            if (substr($method, 0, 5) === '_post') {
                $this->$method();
            }
        }
    }

}

