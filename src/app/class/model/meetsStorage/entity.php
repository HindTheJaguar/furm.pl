<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */

class model_meetsStorage_entity extends yiff_db_model_abstract_entity {
    /**
     *
     * @var SimpleXmlElement
     */
    public $storage;
    public function init() {
        if (empty($this->meet_xml)) {
            $this->storage = simplexml_load_string('<meet></meet>');
        } else {
            $this->storage = simplexml_load_string($this->meet_xml);
        }
    }

    public function save() {
        $this->meet_xml = $this->storage->asXml();
        parent::save();
    }


}