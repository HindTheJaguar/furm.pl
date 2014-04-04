<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */

class model_meetsStorage_search {
    protected $_model;
    protected $_meet;
    public function __construct($model) {
        $this->_model = $model;
    }

    public function setMeet($meet) {
        $this->_meet = $meet;
        return $this;
    }

    public function node($node) {
        return $this;
    }
}