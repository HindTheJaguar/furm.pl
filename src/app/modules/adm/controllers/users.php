<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-08-17, 21:15:14
 */
namespace adm;
use furm\common\model\user as users;
use yiff;
use model_users as UM;
use model_users_entity as U;
class usersController extends controller {
    public function indexAction() {
        $grid = new grid(U::model()->fetchAll());
        $grid->setColon(array(
            array('name'=>'id','column'=>'id'),
            array('name'=>'name','column'=>'name'),
            array('name'=>'login','column'=>'login'),
            array('name'=>'mail','column'=>'mail'),
            
            array('name'=>'options','type'=>'options','links'=>array(
                array('name'=>'edycja','url'=>port('/adm/users/edit/_id_'),'replace'=>array('_id_'=>'id')),
                array('name'=>'Usuń','url'=>port('/adm/users/delete/_id_'),'replace'=>array('_id_'=>'id')),
                
            ))
        ));
        $grid->render();
    }
    
    public function editAction() {
        $u = U::model()->findOne($this->_getParam(0));
        $f = $this->getForm();
        $f->populate($u);
        if (! $this->_request->isPost()) {
            echo $f;
            return;
        }
        $f->populate($this->_request);
        $u->update($f);
        $u->save();
        $this->_redirect(port('/adm/users'));
    }
    
    public function getForm() {
        $form = new yiff\form\form;
        
        $form->addElement('text', 'login', array(
            'label'=>'login',
        ));
        
        $form->addElement('text', 'name', array(
            'label'=>'name',
        ));
        
        $form->addElement('text', 'mail', array(
            'label'=>'mail',
        ));
        
        $form->addElement('submit', 'button', array(
            'label'=>'Zapisz',
            'ignore'=>true,
        ));
        
        
        return $form;
        
    }
}