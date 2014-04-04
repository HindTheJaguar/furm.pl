<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */

class model_forumTopics extends yiff_db_model_abstract {
    protected $_name = 'forum_topics';

    public function findLast($cnt,$offset = 0) {
        return $this->fetchAll(null,$cnt,'date_last DESC');
    }

    public function findLastOne($id) {
        return $this->fetchRow(array('forum_id = ?'=>$id),'date_last DESC');
    }

    public function findByCategory(yiff_db_model_abstract_entity $category) {
        return $this->fetchAll(array('forum_id = ?' => $category->id),null,'date_last DESC');
    }

    public function sum($id) {
        $id = (int) $id;
        return $this->_db->single("SELECT COUNT(*) FROM ".$this->_name." WHERE forum_id = ".$id);
    }
}
