<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */
namespace furm;
use model_meets;
use model_users;


class browseController extends controller {
    public function meetAction() {
        $this->view->page = 'Przeglądaj meety';
        $model = new model_meets;
        $this->view->list = $model->fetchAll(null,'date_end DESC');
   
    }

    public function usersAction() {
        $this->view->page = 'Przeglądaj futra';
        $users = new model_users;
        $s = $this->_getParam(0);
        if (empty($s)) {
            $u = $users->fetchAll();
        } elseif($s == '123') {
            $u = $users->fetchAll("upper(substr(login,1,1)) in ('1','2','3','4','5','6','7','8','9','0','_')");
        } else {
            $u = $users->fetchAll('upper(substr(login,1,1)) = \''.strtoupper(substr($s,0,1)).'\'');
        }

        $this->view->users = $u;
    }
}
