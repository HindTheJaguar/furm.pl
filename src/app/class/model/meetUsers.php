<?php
class model_meetUsers extends yiff_db_model_abstract {
    protected $_primary = array('user_id','meet_id');
    protected $_sequence = false;
    protected $_name = 'meets_users';
    protected $_rowClass = 'model_meetUsers_entity';

    /**
     * @var model_meets
     */
    public $meets;
    
    /**
     * @var model_users
     */    
    public $users;
    
    /**
     * 
     * @param model_meets_entity $m
     * @param model_users_entity $u
     * @param int $prio
     * @param string $store
     * @return boolean
     * @throws \yiff\stdlib\NoFound
     */
    public function replace(model_meets_entity $m, model_users_entity $u, $prio = 0, $store = '[]') {
        
        $data = array(
            'meet_id'=>$m->id,
            'user_id'=>$u->id,
            'date'=>new \yiff\db\expr('now()'),
            'prio'=>(int)$prio,
            'storage'=>$this->_db->escapeString($store),
        );
        try {
            if($r = $this->findOne($data)) {
                $r->update(array('storage'=>$store,'prio'=>$prio,'date'=>new \yiff\db\expr('now()')))->save();    
                return true;
            } else {
                throw new \yiff\stdlib\NoFound;
            }
        } catch(\yiff\stdlib\NoFound $e) {
            $this->insert($data);
            
            return true;
        }
        
    }
    
    /**
     * 
     * @param model_meets_entity $meet
     * @param type $populate
     * @return array
     */
    public function findByMeet(model_meets_entity $meet, $populate = false) {
        $meetId = $meet->id;
        
        $ret = $this->fetchAll(array('meet_id = ?'=>$meetId),'date ASC');
        if(!count($ret)) {
            return [];
        }
        $ret2 = array();
        $uids = array() ;
        foreach ($ret as $v) {
            $uids[$v->user_id] = $v->user_id;
            $v->setMeet($meet);
            $ret2[$v->user_id] = $v;
        }
        
        if (! $uids) {
            return [];
        }
        if ($populate) {
            $u = $this->users->find($uids);
            foreach($ret as $v) {
                $v->setUser($u[$v->user_id]);
            }
        }
        
        return $ret2;
    } 
    
}
