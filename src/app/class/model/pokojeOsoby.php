<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */

class model_pokojeOsoby extends yiff_db_model_abstract {
    protected $_name = 'pokoje_osoby';
    protected $_primary = array('user_id','meet_id');
    static $_instance;

    /**
     *
     * @return model_pokojeOsoby
     */
    static public function getInstance() {
        if (! self::$_instance)
            self::$_instance = new self;
        return self::$_instance;
    }

    public function findByMeet(model_meets_entity $meet) {
        return $this->fetchAll(array('meet_id = ?'=>$meet->id), null, 'pokoj_id ASC, created ASC');
    }

    public function set($pokoj, $user) {
        return $this->insert(array(
            'meet_id' => $pokoj->meet_id,
            'pokoj_id'=>$pokoj->id,
            'user_id'=>$user->id,
        ));
    }
}