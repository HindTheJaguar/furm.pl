<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-07-11, 20:00:18
 */

namespace furm\meets\model;
/**
 * @yiff-db-table:meets
 */
class meet extends \yiff_db_model_abstract_entity {
    protected $_metaData = [
        'primary'=>'id',
        'table'=>'meets',
        'sequence'=>true,
    ];
    
    public function getUrl() {
        return port('/meet/:id:/:name:',array('id'=>$this->id,'name'=> \urlchr($this->name)));
    }

    public function getState() {
        if (isset(\furm\hyper\states::$states[$this->state])) {
            return \furm\hyper\states::$states[$this->state];
        }
        return '-BRAK-';
    }
    
    public function __toString() {
        return $this->name;
    }
}