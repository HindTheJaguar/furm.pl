<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */

class model_meetsStorage extends yiff_db_model_abstract {
    protected $_name = 'meets_storage';
    protected $_primary = 'meet_id';
    protected $_sequence = false;
    protected $_rowClass = 'model_meetsStorage_entity';

    public function search() {
        return new model_meetsStrorage_search($this);
    }
}
