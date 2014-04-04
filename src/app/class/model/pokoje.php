<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */

class model_pokoje extends yiff_db_model_abstract {
    protected $_name = 'pokoje';
    public $dependency = array('users'=>'model_users');
    
    /**
     * @var model_users
     */
    public $users;
    public function findByMeet($meet) {
        return $this->fetchAll(array('meet_id = ?'=>$meet->id),null,'id ASC');
    }
}