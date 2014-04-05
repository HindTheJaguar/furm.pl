<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */

class blogController extends furm\controller {
    protected $news;
    public function init() {
        $this->news = new model_news;
        $this->news->users = new model_users;
    }
    public function indexAction() {
        $this->view->page = 'Blog';
        $this->view->news = $this->news->findLast(10);
    }
    
    public function showAction() {
        if(!$this->view->news = $this->news->findOne($this->_getParam(0,0))) {
            throw new yiff\stdlib\NoFound;
        }
        $this->view->page = $this->view->news->name;
    }
}
