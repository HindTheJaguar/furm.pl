<?php
class model_sessions extends yiff_db_model_abstract {
    protected $_name = 'sessions';
    protected $_sequence = false;
    protected $_primary = 'session_id';
    
    public function fetchByUser($user) {
        return $this->fetchAll(array('user_id = ?'=>$user->id));
    }
}
