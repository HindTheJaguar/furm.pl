<?php
class model_meetUsers_entity extends yiff_db_model_abstract_entity {
    protected $_meet;
    protected $_user;
    
    public function setMeet(model_meets_entity $m) {
        $this->_meet = $m;
    }
    
    public function setUser(model_users_entity $u) {
        $this->_user = $u;
    }
    
    public function __getUser() {
        $this->_user || $this->_user = $this->_model->users->findOne($this->user_id);
        return $this->_user;
    }
    
    public function __getMeet() {
        $this->_meet || $this->_meet = $this->_model->meets->findOne($this->meet_id);
        return $this->_meet;
    }
}
