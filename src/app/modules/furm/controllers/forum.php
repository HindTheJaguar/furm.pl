<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */
namespace furm;
use yiff;
use model_forumTopics;
use model_forumPosts;
use model_forumText;

class forumController extends controller {
    public function indexAction() {
        $this->view->page = 'Forum';
        try {
            $this->view->list = \furm\forum\model\topic::model()->fetchAll([],'modified DESC');
        } catch (\yiff\stdlib\NoFound $e) {
            $this->view->list = null;
        }
    }
    
    public function newtopicAction() {
        if (!uid()) {
            $this->_redirect(port('/auth/login'));
        }
        $this->view->page = 'Nowy temat';
        $this->view->request = $this->_request;
        
        if (! $this->_request->isPost()) {
            return;
        }
        
        if (! $this->_request->getParam('topic')) {
            return;
        }
        
        $t = new model_forumTopics;
        $id = $t->insert(array(
            'forum_id'=>0,
            'user_id'=>uid(),
            'name'=>$this->_request->getParam('topic'),
            'flags'=>0,
        ));
        
        $p = new model_forumPosts;
        $pid = $p->insert(array(
            'user_id'=>uid(),
            'created'=>new \yiff\db\expr('now()'),
            'flags'=>0,
            'ip'=>$_SERVER['REMOTE_ADDR'],
            'useragent'=>$_SERVER['HTTP_USERAGENT'],
            'topic_id'=>$id,
        ));
        
        $t = new model_forumText;
        $t->insert(array(
            'id'=>$pid,
            'modified'=>new \yiff\db\expr('now()'),
            'content'=>$this->_request->getParam('text'),
        ));
        $this->_redirect(port('/forum/topic/:id:',array('id'=>$id)));
    }
    
    public function postAction() {
        if (! uid()) {
            throw new yiff\stdlib\Restricted;
        }
        if (! $this->_request->isPost()) {
            return;
        }
        $id = $this->_request->getParam(0);
        
        $p = new model_forumPosts;
        
        $post = $p->create(array(
            'user_id'=>uid(),
            'created'=>new \yiff\db\expr('now()'),
            'flags'=>0,
            'ip'=>$_SERVER['REMOTE_ADDR'],
            'useragent'=>$_SERVER['HTTP_USERAGENT'],
            'topic_id'=>$id,
        ));
        
        $post->save();
        
        $t = new model_forumText;
        $t->insert(array(
            'id'=>$post->id,
            'modified'=>new \yiff\db\expr('now()'),
            'content'=>$this->_request->getParam('text'),
        ));
        
        
        $this->_redirect(port('/forum/topic/:id:',array('id'=>$id)));
    }
    
    public function topicAction() {
        $row = \furm\forum\model\topic::model()->findOne($this->_request->getParam('0'));
        $this->view->topic = $row;
        $this->view->page = $row->name;
        $this->view->posts = \furm\forum\model\view::model()->fetchAll(['topic_id = ?'=>$row->id],'id ASC');
    }
}
