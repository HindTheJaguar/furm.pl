<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */

class model_news extends yiff_db_model_abstract {
    protected $_name = 'news';
    protected $_rowClass = 'model_news_entity';
    public $users;
    
    public function findLast($num,$start=0) {
        return $this->fetchAll('flags <> 1',null, $num);
    }
}
