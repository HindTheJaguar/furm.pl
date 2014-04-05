<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-06-21, 16:21:31
 */
class yiff_db_iterator implements Iterator {

    /**
     *
     * @var yiff_db_adapter
     */
    protected $db;
    
    /**
     *
     * @var Resource
     */
    protected $res;
    
    /**
     *
     * @var \yiff\db\stmt 
     */
    protected $stmt;
    
    public function __construct($params) {
        $this->db = $params['db'];
    }
    
    public function current() {
        
    }

    public function key() {
        
    }

    public function next() {
        
    }

    public function rewind() {
        
    }

    public function valid() {
        
    }

}