<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */

class model_meetsHistory_entity extends yiff_db_model_abstract_entity {
    protected $_content = null;
    protected $_user;
    public function getContent() {
        if (! $this->_content) {
            $this->_content = (object) unserialize($this->content);
        }
        return $this->_content;
    }

    public function getState() {
        return \furm\hyper\states::$states[$this->getContent()->state];
    }

    public function __getUser() {
        if (! $this->_user && $this->_model->users) {
            $this->_user = $this->_model->users->findOne($this->getContent()->userid);
        }
        return $this->_user;
    }
}