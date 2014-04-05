<?php 
namespace furm;
use model_meets;
use model_users;
use model_meetUsers;
use model_meetComments;
use yiff;

class addmeController extends yiff\application\controller {
    public function meetAction() {
        $id = $this->_getParam(0);
        $prio = $this->_getParam('prio',0);
        $meets = new model_meets;
        $users = new model_users;
        $meet = $meets->findOne($id);
        $access = yiff\stdlib\Registry::get('user');
        $user = $users->getCurrnet($access);
        $mu = new model_meetUsers;
        $mu->replace($meet,$user,$prio);
        $this->_redirect(port('/meet/:id:',array('id'=>$id)));
    }
    
    public function commentAction() {
        if (! $this->_request->isPost()) {
            throw new \yiff\stdlib\NoFound;
        }
        $id = $this->_getParam(0);
        $content = $this->_getParam('content');
        $tree_id = (int) $this->_getParam('tree_id');
        
        $c = new model_meetComments;
        $m = new model_meets;
        
        if (! $meet = $m->findOne($id)) {
            throw new yiff\stdlib\NoFound;
        }
        
        if ($tree_id) {
            if(!$c1 = $c->findOne($tree_id)) {
                throw new yiff\stdlib\NoFound;
            }
        } else {
            $tree_id = null;
        }
        
        $access = yiff\stdlib\Registry::get('user');
        if ($access->isGuest()) {
            throw new yiff\stdlib\Restricted;
        }
        $data = array(
            'meet_id'=>$meet->id,
            'tree_id'=>$tree_id,
            'content'=>$content,
            'user_id'=>$access->getUid(),
            'date'=>new \yiff\db\expr('now()'),
            'ip'=>$_SERVER['REMOTE_ADDR'],
            'ua'=>$_SERVER['HTTP_USER_AGENT'],
        );
        $d = $c->insert($data);
        if (!$tree_id) {
            $c->update(['tree_id'=>$d], ['id = ?'=>$d]);
        }
        $this->_redirect(port('/meet/:id:#comment-:comment:',array('comment'=>$d,'id'=>$meet->id)));
        
    }
    
    public function deletecommentAction() {
        $c = new model_meetComments;
        $id = $this->_getParam(0);
        $cc = $c->findOne($id);
        $a = $this->get('user');
        /* @var $a \yiff\auth\User */
        if ($cc && $cc->user_id === $a->getUid() || $a->isAdmin()) {
            $cc->deleted = true;
            $cc->save();
            $this->_redirect(port('/meet/:id:#comment-:comment:',array('comment'=>$cc->id,'id'=>$cc->meet_id)));
        } else {
            $this->app->msg->add(__('Brak uprawnień'),yiff\helpers\msg::E_WRONG,yiff\helpers\msg::T_FLASH);
            $this->_redirect(port('/meet/:id:#comment-:comment:',array('comment'=>$cc->id,'id'=>$cc->meet_id)));
        }
        
    }
}
