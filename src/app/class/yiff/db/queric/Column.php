<?php

/**
 * System EKL
 * 
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2013-10-09, 16:35:41
 * 
 * Opis zmian:
 * 2013-10-09:
 * -Utworzenie pliku
 */

namespace yiff\db\queric;

class Column implements RawInterface
{

    protected $_column;

    public function __construct($column)
    {
        $this->_column = $column;
    }

    public function getQueryPart()
    {
        return $this->_column;
    }

}
