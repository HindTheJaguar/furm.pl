<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */

class model_meetsHistory extends yiff_db_model_abstract {
    protected $_name = 'meets_history';
    protected $_rowClass = 'model_meetsHistory_entity';
    public $users;
    public function findByMeet(model_meets_entity $meet) {
        return $this->fetchAll(array('meet_id = ?'=>$meet->id), null, 'date DESC');
    }

    public function store(model_meets_entity $meet , $user_id = null) {
        $row = $this->create(array(
            'content'=> serialize($meet->toArray()),
            'meet_id'=>$meet->id,
            'user_id'=>$meet->user_id,
            'date'=>new \yiff\db\expr('now()'),
        ));
        return $row;
    }
}