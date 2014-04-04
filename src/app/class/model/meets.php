<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */

class model_meets extends yiff_db_model_abstract {
    protected $_name = 'meets';
    protected $_rowClass = 'model_meets_entity';
    public $history;
    protected $filters = array(
        'date_start'=>array(
            'from_unixtime'
        ),
        'date_end'=>array(
            'from_unixtime',
        ),
    );

    public function upcomming($num = null) {
        return $this->fetchAll(array('date_end > ?'=>new \yiff\db\expr('now()')),'date_end ASC',$num);
    }

    public function findLast($num = null) {
        return $this->fetchAll(array('date_end < ?'=>new \yiff\db\expr('now()')),'date_end DESC',$num);
    }
}
