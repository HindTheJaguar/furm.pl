<?php

/**
 * System EKL
 * 
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2014-02-12, 15:51:22
 * 
 * Opis zmian:
 * 2014-02-12:
 * -Utworzenie pliku
 */

namespace yiff\conf;

class conf {
    public function __construct($params) {
        foreach($params as $k=>$v) {
            if (is_array($v)) {
                $this->$k = new self($v);
            } else {
                $this->$k = $v;
            }
        }
    }
    
    public function toArray() {
        return (array) $this;
    }
}
