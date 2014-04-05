<?php

/**
 * System EKL
 * 
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2013-10-09, 16:27:27
 * 
 * Opis zmian:
 * 2013-10-09:
 * -Utworzenie pliku
 */

namespace yiff\db\queric;

class Table implements RawInterface
{
    protected $_table;
    /**
     *
     * @var \yiff_db_adapter
     */
    protected $_db;
    public function __construct($table, $db) {
        $this->_table = $table;
        $this->_db = $db;
    }
    
    /**
     * 
     * @return array
     */
    public function columns()
    {
        return array_keys($this->_db->describe_table($this->_table));
    }
    
    public function getQueryPart()
    {
        return $this->_table;
    }
}