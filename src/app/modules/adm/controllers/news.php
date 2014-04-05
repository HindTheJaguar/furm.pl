<?php
namespace adm;
use yiff;
use model_news_entity as N;

class newsController extends controller {
    public function init() {
        $am = new actionMenu();
        $am->add('all','Wszystkie newsy',port('/adm/news'));
        $am->add('new', 'Nowy news', port('/adm/news/new'));
        $this->setActionMenu($am);
        parent::init();
    }
    public function indexAction() {
        
        $mapper = N::model()->fetchAll();
        $grid = new grid($mapper);
        
        $grid->setColon(array(
            array('name'=>'id','column'=>'id'),
            array('name'=>'name','column'=>'name'),
            array('name'=>'date','column'=>'date'),
            array('name'=>'options','type'=>'options','links'=>array(
                array('name'=>'edycja','url'=>port('/adm/news/edit/_id_'),'replace'=>array('_id_'=>'id')),
                array('name'=>'Usuń','url'=>port('/adm/news/delete/_id_'),'replace'=>array('_id_'=>'id')),
                
            ))
        ));
        
        $grid->render();
        
        return;
        foreach($news->fetchAll() as $v) {
            print_r($v->toArray());
            echo '<a href="'.port('/adm/news/edit',array('id'=>$v->id)).'">Edytuj</a>';
            echo '<hr>';
        }
    }
    
    public function newAction() {
        $form = $this->getForm();
        if (! $this->_request->isPost()) {
            echo $form;
            return;
        }
        $form->populate($this->_request);
        $news = new \furm\common\model\news;
        $news->update($form->getValues());
        $news->date = new \yiff\db\expr('now()');
        $news->save();
        $this->_redirect(port('/adm/news'));
    }
    
    public function editAction() {
        $news = new \model_news;
        if(! $n = $news->findOne($this->_getParam('0',0))) {
        echo 'news no found';
            return;
        }
        
        $form = $this->getForm();
        
        if ($this->_request->isPost()) {
            $form->populate($_REQUEST);
            $n->update($form->toArray())->save();
        } else {
            $form->populate($n->toArray());
        }
        
        echo $form;
        
    }
    
    public function deleteAction() {
        \furm\common\model\news::mapper()->findPK($this->_getParam(0))->delete();
        $this->_redirect(port('/adm/news'));
    }
    
    public function getForm() {
        $form = new yiff\form\form;
        $el = new yiff\form\element\text('name');
        $el->setLabel('nazwa');
        $form->setElement($el);
        
        $el = new yiff\form\element\textarea('content');
        $el['style']='width:99%';
        $el->setLabel('treść');
        $form->setElement($el);
        
        $el = new yiff\form\element\submit('button');
        $el->setLabel('Zapisz')->setIgnore();
        $form->setElement($el);
        
        return $form;
    }
}
