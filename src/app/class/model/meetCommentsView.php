<?php
class model_meetCommentsView extends yiff_db_model_abstract {
    protected $_readonly = true;
    protected $_name = 'meets_comments_view';
    
    public function findLast($limit = 10) {
        return $this->fetchAll('1=1', $limit, 'id DESC');
    }
}
