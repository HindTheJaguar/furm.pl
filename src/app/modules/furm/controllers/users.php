<?php

/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */
namespace furm;
use yiff;
use model_aboutMe;
use model_usersAttr;
use model_users;

class usersController extends controller {

    public function showAction() {
        $this->view->setFile('furm/views/users/index.php');
        $action = $this->_request->getParam('0', 'index');

        if (!$action) {
            throw new yiff\stdlib\NoFound;
        }

        $users = new model_users;
        if (!$user = $users->findByLogin($action)) {
            throw new yiff\stdlib\NoFound;
        }


        $access = \yiff\stdlib\Registry::get('user');

        if ($access->getUid() === $user->id) {
            $this->view->show_home = 1;
        } else {
            $this->view->show_home = 0;
        }

        if ($access->isGuest() && $user->hasFlag('hide_profile')) {
            throw new yiff\stdlib\Restricted;
        }

        $this->view->user = $user;

        $m = new model_aboutMe();
        $m2 = new model_usersAttr;
        $data = $m2->fetchAll(array('user_id = ?' => $user->id));
        $this->view->list = $m->crossData($data);
        $this->view->page = $user->name;
    }

}
