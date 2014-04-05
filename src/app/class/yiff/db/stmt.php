<?php
namespace yiff\db;
use PDO;
class stmt {
    /**
     *
     * @var \PDOStatement
     */
    protected $_res;
    protected $_query;
    public function __construct($res,$query) {
        $this->_res = $res;
        $this->_query = $query;
    }
    
    public function fetch($fetch = PDO::FETCH_ASSOC) {
        return $this->_res->fetch($fetch);
    }

    public function fetchAll($fetch = PDO::FETCH_ASSOC) {
        return $this->_res->fetchAll($fetch);
    }
    
    public function count() {
        return $this->_res->rowCount();
    }
    
    public function affected() {
        return $this->_res->rowCount();
    }

    public function getQuery() {
        return $this->_query;
    }

    public function isError() {
        return ! $this->_res;
    }
    
}
