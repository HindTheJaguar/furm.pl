<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */

class model_forumPosts_entity extends yiff_db_model_abstract_entity {
    public function attachToTopic($topic) {
        $this->topic_id = $topic->id;
        return $this;
    }
}
