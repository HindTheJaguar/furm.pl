<?php

/**
 * System EKL
 * 
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2013-10-03, 06:18:59
 * 
 * Opis zmian:
 * 2013-10-03:
 * -Utworzenie pliku
 */
namespace yiff\db\queric;

class Raw {
    public $expr;
    
    public function __construct($expr)
    {
        $this->expr = $expr;
    }
    public function getQueryPart()
    {
        return $this->expr;
    }
}
