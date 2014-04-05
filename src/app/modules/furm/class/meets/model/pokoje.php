<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-10-22, 09:48:39
 */
namespace furm\meets\model;

class pokoje extends \yiff_db_ActiveRecord {
    protected $_metaData = [
        'table' => 'meets_pokoje',
        'primary'=>'id',
        'sequence'=>true,
        'schema' => [
            'id' => ['type'=>'numeric','index'=>'primary', 'name'=>'ID'],
            'meet_id' => ['type'=>'numeric','index'=>'index', 'name'=>'Meet', 'reference'=>['\\meets\\model\\meet','id','one']],
            'info' => ['type'=>'string','size'=>'64','name'=>'Opis'],
        ],
    ];
}