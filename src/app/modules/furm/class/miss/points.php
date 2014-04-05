<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-03-10, 18:53:34
 */

namespace furm\miss;
use yiff;
class points {
    public $data = array();
    /**
     *
     * @var yiff_db_adapter
     */
    public $db;
    public function __construct() {
        $this->db = yiff\stdlib\Service::get('db');
        foreach($this->db->assoc('select mid, sum(pm) as s ,count(*) as cnt from miss_points group by mid') as $v) {
            $this->data[$v['mid']] = $v;
        }
    }
    
    public function getPoints($id) {
        if (isset($this->data[$id->id])) {
            return $this->data[$id->id]['s'];
        }
        return 0;
    }
    
    
}