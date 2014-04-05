<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-07-16, 20:27:37
 */
namespace home;
use furm\controller;
use yiff;
use \furm\pw\form;

class pwController extends controller {
    public function init() {
        if (!uid()) {
            throw new yiff\stdlib\Restricted;
        }
        parent::init();
    }

    public function indexAction() {
        $this->view->setFile('home/views/pw/index.php');
        switch ($this->_request->getParam('0')) {
            case 'send':
                $this->view->page = 'Wiadomości wysłane';
                $this->view->list = model\pw::model()->fetchAll(['user_id = ?'=>uid()],'id DESC');
                
                break;
            default:
                $this->view->page = 'Wiadomości odebrane';
                $this->view->list = model\pw::model()->fetchAll(['to_user_id = ?'=>uid()],'id DESC');
                        
        }
    }
    
    public function newAction() {
        $this->view->page = 'Nowa wiadomość';
        $this->view->form = $form = new form\pw;
        if ($this->_request->getParam('0') == 'user') {
            $user = (int) $this->_request->getParam('1');
        } else {
            $user = (int) $this->_request->getParam('user');
        }
        try {
            if (!$user) {
                throw new \yiff\stdlib\NoFound;
            }
            $this->view->user = $user = \model_users_entity::model()->findOne($user); 
        } catch (\yiff\stdlib\NoFound $e) {
            yiff\stdlib\Service::get('msg')->add('Proszę wybrać osobę do której chcesz wysłać wiasomość');
            return;
        }
        
        if (! $this->_request->isPost()) {
            return;
        }
        $values = $form->populate($this->_request)->getValues();
        
        $pw = model\pw::model()->create(array(
            'topic'=>$values['topic'],
            'body'=>$values['body'],
            'user_id'=>uid(),
            'to_user_id'=>$user->id,
            'ip'=>$_SERVER['REMOTE_ADDR'],
            'useragent'=>$_SERVER['HTTP_USER_AGENT'],
            'topic_id'=>0,
        ));
        
        $pw->save();
        $this->_redirect(port('/home/pw/topic/'.$pw->id));
    }
    
    public function topicAction() {
        $msg = model\pw::model()->findOne((int)$this->_request->getParam(0));
        if (!($msg->user_id == uid() || $msg->to_user_id == uid())) {
            throw new \yiff\stdlib\NoFound;
        }
        $this->view->page = $msg->topic;
        $this->view->msg = $msg;
        
        $this->view->list = model\pw::model()->fetchAll(
                '(user_id = '.$msg->user_id.' AND to_user_id = '.$msg->to_user_id.')'.
                ' OR (user_id = '.$msg->to_user_id.' AND to_user_id = '.$msg->user_id.')'
                ,'id ASC');
        $uid = $msg->user_id == uid()?$msg->to_user_id:$msg->user_id;
        $this->view->url = port('/home/pw/new/user/'.$uid);
    }
    
    public function listAction() {
        $this->indexAction();
    }
    
    public function deleteAction() {
        $this->view->page = 'Usuwanie wiadomości';
        $msg = model\pw::model()->findOne((int)$this->_getParam(0));
        if ($msg->user_id == uid()) {
            if($msg->flags == model\pw::T_DELETED_RECV) {
                $msg->delete();
            } else {
                $msg->flags = model\pw::T_DELETED_OWN;
                $msg->save();
            }
            
        } else if ($msg->to_user_id == uid()) {
            if($msg->flags == model\pw::T_DELETED_OWN) {
                $msg->delete();
            } else {
                $msg->flags = model\pw::T_DELETED_RECV;
                $msg->save();
            }
        } else {
            throw new \yiff\stdlib\NoFound;
        }
    }
}