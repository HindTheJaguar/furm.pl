<?php
namespace furm;
use yiff;
use model_meets;
use model_news;

class indexController extends controller{
    public function indexAction() {
        $this->view->page = 'Strona główna';
        $meets = new model_meets;
        $this->view->meets = $meets->upcomming();
        $this->view->last = $meets->findLast(5);
//        $c = new model_meetCommentsView;
        $this->view->comments = array();//$c->findLast(10);
        
        $w = new model_news;
        $this->view->news = $w->findLast(10);
        
        $this->view->access = yiff\stdlib\Registry::get('user');
    }
}
