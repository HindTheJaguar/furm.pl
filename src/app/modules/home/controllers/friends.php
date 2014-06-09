<?php

/**
 * System EKL
 * 
 * @author Przemysław 'Hind' Jakubowski <przemyslaw.jakubowski@pkp-cargo.eu>
 * @date 2014-05-15, 15:36:01
 * 
 * Opis zmian:
 * 2014-05-15:
 * -Utworzenie pliku
 */

namespace home;
use furm;
use yiff;

class friendsController extends furm\controller
{
    public function indexAction()
    {
        $this->view->friends = model\friends::model()->select()->where('user_id',  uid());
    }
    
    public function addAction()
    {
        $id = (int) $this->_request->getNamedParam('id');
   
        $this->view->error = 'ok';
        if ($this->_request->getNamedParam('xhr')) {
            $this->view->setFile(ROOT.'/modules/home/views/friends/add_xhr.php');
        }
        
        if ($row = model\friends::model()->fetchRow([
            'user_id = ?'=>uid(),
            'friend_id = ?'=>$id,
        ])) {
            $this->view->error = 'duplicate';
            return;
        }
        
        try {
            $friend = \model_users_entity::model()->findOne($id);
            model\friends::model()->insert([
                'user_id'=>uid(),
                'friend_id'=>$id,
            ]);
        } catch (yiff\stdlib\NoFound $e) {
            $this->view->error = 'nofound';
            return;
        }
    }
    
    public function removeAction()
    {
        $this->view->deleted = model\friends::model()->delete(['user_id = ?'=>uid(),
            'friend_id = ?'=>(int)$this->_request->getNamedParam('id')]);
    }
    
    public function waitingAction()
    {
        $this->view->list = model\friends::model()->select()->exists(function($w) {
            $w->from('friends')
                    ->rawWhere('friends.user_id = basetable.friend_id')
                    ->rawWhere('friends.friend_id = basetable.user_id');
        }, false)
            ->where('user_id',uid());
    }
}