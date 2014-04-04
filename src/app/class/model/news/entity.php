<?php
/**
 * @yiff-db-table:news
 */
class model_news_entity extends yiff_db_model_abstract_entity {
    public function __getUser() {
        return $this->_model->users->findOne($this->user_id);
    }
    
    public function __toString()
    {
        return $this->name;
    }
}
