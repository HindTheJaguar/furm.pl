<?php
namespace furm\forum\model;
/**
 * @yiff-db-table:forum_topics
 */
class topic extends \yiff_db_model_abstract_entity {
    protected $_metaData = array(
        'table'=>'forum_topics',
        'primary'=>'id',
        'sequence'=>true,
    );
    
    public function getLastPost() {
        return posts::model()->fetchRow(['topic_id = ?' => $this->id],'id DESC');
    }
    
    public function getUser() {
        return \model_users_entity::model()->fetchRow(['id = ?'=>$this->user_id]);
    }
    
    public function _doInsert() {
        $this->created = new \yiff\db\expr('now()');
        return parent::_doInsert();
    }
}