<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */

class model_forumPosts extends yiff_db_model_abstract {
    protected $_name = 'forum_posts';
    protected $_rowClass = 'model_forumPosts_entity';
    public function findByTopic($t) {
        return $this->fetchAll(array('topic_id = ?'=>$t->id),null,'date ASC');
    }
}