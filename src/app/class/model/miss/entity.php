<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-03-10, 18:46:05
 */


class model_miss_entity extends yiff_db_model_abstract_entity {
    public function getUser() {
        return $this->_model->users->findOne($this->user_id);
    }
    
    public function points() {
        return $this->_model->points->getPoints($this);
    }
}