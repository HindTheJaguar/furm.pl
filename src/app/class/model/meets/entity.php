<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */

/**
 * @yiff-db-table:meets
 */
class model_meets_entity extends yiff_db_model_abstract_entity {
    public function getUrl() {
        return port('/meet/:id:/:name:',array('id'=>$this->id,'name'=> urlchr($this->name)));
    }

    public function getState() {
        if (isset(\furm\hyper\states::$states[$this->state])) {
            return \furm\hyper\states::$states[$this->state];
        }
        return '-BRAK-';
    }
    
    public function __toString()
    {
        return $this->name;
    }
}
