<?php
namespace furm\forum\model;
/**
 * @yiff-db-table:forum_text
 */
class content extends \yiff_db_model_abstract_entity {
    protected $_metaData = array(
        'table'=>'forum_text',
        'primary'=>'id',
        'sequence'=>false,
    );
}
