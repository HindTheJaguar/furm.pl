<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-07-10, 17:08:51
 */


namespace furm\forum\model;
/**
 * @yiff-db-table:forum_view
 */
class view extends \yiff_db_model_abstract_entity {
    protected $_metaData = array(
        'table'=>'forum_view',
        'primary'=>'id',
        'readonly'=>true,
    );
}