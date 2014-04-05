<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-07-11, 19:01:35
 */

namespace furm\meets\model;

/**
 * @yiff-db-table:meets_news
 */
class news extends \yiff_db_model_abstract_entity
{

    protected $_meet, $_user;
    protected $_metaData = array(
        'table' => 'meets_news',
        'primary' => 'id',
        'sequence' => true,
        'ref' => [
            'user' => ['local' => 'user_id', 'remote' => 'id', 'table' => '\\furm\\common\\model\\user'],
            'meet' => ['local' => 'meet_id', 'remote' => 'id', 'table' => '\\furm\\meets\\model\\meet'],
        ]
    );

    public function getMeet()
    {
        if (!$this->_meet) {
            $this->_meet = \model_meets_entity::model()->findOne($this->meet_id);
        }
        return $this->_meet;
    }

    public function getUser()
    {
        if (!$this->_user) {
            $this->_user = \model_users_entity::model()->findOne($this->user_id);
        }
        return $this->_user;
    }

    public function getUrl()
    {
        return port('/meets/news/show/:id:', array('id' => $this->id));
    }

}
