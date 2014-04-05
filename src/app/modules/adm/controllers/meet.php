<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2013-08-28, 19:05:48
 */

namespace adm;
use furm;
use model_meets;
class meetController extends furm\adm\controller {
    public function deleteAction() {
        $m = new model_meets();
        $o = $m->findOne($this->_request->getParam('0'));
        $o->delete(); 
        echo 'ok';
    }
}