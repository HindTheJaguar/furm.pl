<?php
namespace home;
use furm\controller;
use model_aboutMe;
use model_usersAttr;
use yiff;

class aboutController extends controller {

public function indexAction() {
    $this->view->page = 'Dane dodatkowe';
    $m = new model_aboutMe();
    $m2 = new model_usersAttr;
    $a = \yiff\stdlib\Registry::get('user');


    if ($a->isGuest()) {
        throw new yiff\stdlib\Restricted;
    }

    if ($this->_request->isPost()) {
        $d = array();
        foreach ($_REQUEST['option'] as $k=>$v) {
            $d[]=array('attr_id'=>$k,'value'=>$v,'user_id'=>$a->getUid());
        }
        $m2->multiUpdate($d);
        yiff\stdlib\Service::get('msg')->add('Zapisano');
    }


    $data = $m2->fetchAll(array('user_id = ?'=>$a->getUid()));

    $this->view->list = $m->crossData($data);


}
}
