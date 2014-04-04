<?php
class model_meetComments extends yiff_db_model_abstract {
    protected $_name = 'meets_comments';
    protected $_rowClass = 'model_meetComments_entity';
    public $users;
    
    public function findByMeet(model_meets_entity $m) {
        return $this->fetchAll(array('meet_id = ?'=>$m->id),'tree_id ASC, date ASC');
    }
    
    protected function _preInsert($data) {
        if (empty($data['tree_id'])) {
            $data['tree_id'] = $data['id'];
        }
    }

    public function countByMeet($meet) {
        return $this->_db->fetchValue("SELECT COUNT(*) FROM ".$this->_name.' WHERE meet_id = '.$meet->id);
    }
    
}
