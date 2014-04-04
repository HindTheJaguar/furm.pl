<?php
class model_meetComments_entity extends yiff_db_model_abstract_entity {
    protected $_user;
    public function __getUser() {
        $this->_user || $this->_user = $this->_model->users->findOne($this->user_id);
        return $this->_user;
    }
}
