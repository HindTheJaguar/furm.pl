<?php

/**
 * 
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-07-11, 20:42:01
 * 
 */

namespace yiff\paginator;

class paginator implements \IteratorAggregate, \Countable
{

    protected $_count = 0;
    protected $_iterator = array();
    protected $_perPage = 20;
    protected $_page;
    public $maxpage;

    public function __construct($params)
    {
        if (is_numeric($params)) {
            $this->_count = $params;
        } else if ($params instanceof \yiff\db\model\rowsetAbstract) { // XXX
            $this->_count = count(clone $params);
            $this->_iterator = clone $params;
        } else {
            throw new exception('not supported');
        }
    }

    public function count()
    {
        return $this->_count;
    }

    public function getIterator()
    {
        $this->_iterator->limit($this->getLimit(), $this->getOffset());
        return $this->_iterator;
    }

    public function setPerPage($perPage)
    {
        $this->_perPage = $perPage;
        $this->_calcPageNum();
        return $this;
    }

    public function getPerPage()
    {
        return $this->_perPage;
    }

    public function setPage($page)
    {
        if ($this->inRange($page)) {
            $this->_page = $page;
        }
        return $this;
    }

    protected function _calcPageNum()
    {

        $maxpage = $this->_count / $this->_perPage;
        $this->maxpage = floor($maxpage);
        if ($this->maxpage && $this->maxpage == $maxpage) {
            $this->maxpage--;
        }
    }

    public function getMaxPage()
    {
        return $this->maxpage;
    }

    public function getLimit()
    {
        return $this->_perPage;
    }

    /**
     * Pobiera offset dla sql
     */
    public function getOffset()
    {
        return $_this->_page * $this->_perPage;
    }

    function getNext()
    {
        $c = $this->_page + 1;
        if ($c <= $this->maxpage)
            return $c;
        return $this->_page;
    }

    /**
     * Zwraca id poprzedniej strony
     *
     * @return integer
     */
    function getPrev()
    {
        $c = $this->_page - 1;
        if ($c <= 0)
            return 0;
        return $c;
    }

    /**
     * zwraca id aktualnej podstrony
     *
     * @return array
     */
    function current()
    {
        return $this->_page;
    }

    public function getPageName()
    {
        return $this->_page + 1;
    }

    public function getMaxPageName()
    {
        return $this->maxpage + 1;
    }

    public function inRange($page)
    {
        if ($page >= 0 && $page <= $this->maxpage) {
            return true;
        }
        return;
    }

}
