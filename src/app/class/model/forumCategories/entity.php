<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */

class model_forumCategories_entity extends yiff_db_model_abstract_entity {
    //protected $last, $count;
    public function sumTopics() {
        if (!isset($this->count)) {
            $this->count = $this->_model->forum_topics->sum($this->id);
        }
        return $this->count;
    }

    public function lastTopic() {
        if (!isset($this->last)) {
            $this->last = $this->_model->forum_topics->findLastOne($this->id);
        }
        return $this->last;
    }

    public function __getCount() {
        return $this->sumTopics();
    }

    public function __getLast() {
        return $this->lastTopic();
    }

    public function __setCount($v) {
        $this->count = $v;
    }

    public function __setLast($v) {
        $this->last = $v;
    }



    public function free() {
        //$this->last = null;
        //$this->count = null;
        unset($this->last);
        unset($this->count);
    }
}
