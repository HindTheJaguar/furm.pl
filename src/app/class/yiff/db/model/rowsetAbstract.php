<?php

/**
 * Yiff Framework
 * 
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2014-02-11, 06:06:37
 * 
 * Opis zmian:
 * 2014-02-11:
 * -Utworzenie pliku
 */

namespace yiff\db\model;

use yiff;
use ArrayIterator;
use Countable;
use IteratorAggregate;

class rowsetAbstract implements
Countable, IteratorAggregate, yiff\stdlib\toArray, \ArrayAccess
{

    protected $_rows = null;
    protected $_rowClass;
    protected $data = [];
    /**
     *
     * @var \yiff_db_model_abstract
     */
    protected $_table;

    public function __construct($conf)
    {
        $this->_data = $conf['data'];
        $this->_rowClass = $conf['row_class'];
        $this->_table = $conf['table'];
        $this->_primary = $conf['primary'];
    }

    public function count()
    {
        return count($this->_data);
    }

    public function getIterator()
    {
        if ($this->_rows === null) {
            $this->_populateRows();
        }
        return new ArrayIterator($this->_rows);
    }

    protected function _populateRows()
    {
        $this->_rows = [];
        foreach ($this->_data as $row) {
            $this->_rows[] = new $this->_rowClass([
                'primary'=>$this->_table,
                'table'=>$this->_table,
                'org'=>$row,
                'data' => $row,
            ]);
        }
    }

    public function toArray()
    {
        return $this->data;
    }
    
    public function offsetExists($offset)
    {   
        return isset($this->data[$offset]);
    }
    
    public function offsetGet($offset)
    {
        if ($this->_rows === null) {
            $this->_populateRows();
        }
        return $this->_rows[$offset];
    }
    
    public function offsetSet($offset, $value)
    {
        ;
    }
    
    public function offsetUnset($offset)
    {
        ;
    }

}
