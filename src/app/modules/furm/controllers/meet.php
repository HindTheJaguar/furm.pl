<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */
namespace furm;
use yiff;
use model_meets;
use stdClass;
use model_meetUsers;
use model_users;
use model_meetsHistory;
use model_meetComments;

class meetController extends controller {
    protected $id;
    public function init() {
        $this->id = $this->_request->getParam(0);
    }
    public function showAction() {
        //parent::dispatch();
        $id = $this->id;
        $meets = new model_meets;
        if ( ! $meet = $meets->findOne($id)) {
            throw new yiff\stdlib\NoFound;
        }
        
        $access =yiff\stdlib\Registry::get('user');
        $this->view->page = $meet->name;

        if(! $access->isGuest()) {
            $this->view->user = $user = $access;
        } else {
            $this->view->user = new stdClass;
        }
        
        $this->view->access = $access;


        $mUsers = new model_meetUsers;
        $mUsers->users = new model_users;
        $mUsers->meets = new $meets;
        
        
        $list = $mUsers->findByMeet($meet,true);
        
        $this->view->users = $list;
        if (isset($user) && isset($list[$user->id]) && $list[$user->id]->prio<>0) {
            $this->view->have = true;
        } else {
            $this->view->have = false;
        }
        
        $this->view->setFile('/furm/views/meet/index.php');
        $this->view->meet = $meet;        

        $this->view->canonical = port();
        // -- komentarze --
        $comments = new model_meetComments;
        $comments->users = $mUsers->users;
        $this->view->comments = $comments->findByMeet($meet,true);
        
    }

    public function historyAction() {
        $id = $this->id;
        $meets = new model_meets;
        if ( ! $meet = $meets->findOne($id)) {
            throw new yiff\stdlib\NoFound;
        }
        $this->view->meet = $meet;
        $history = new model_meetsHistory;
        $history->users = new model_users;
        $this->view->history = $history->findByMeet($meet);
        $this->view->page = "Historia: ".$meet->name;
    }

    public function editAction() {
        $access = yiff\stdlib\Registry::get('user');
        if ($access->isGuest()) {
            throw new yiff\stdlib\Restricted('File no found');
        }

        $form = new \furm\meets\form\meet();
        $this->view->form = $form;


        $id = $this->id;
        $meets = new model_meets;
        if ( ! $meet = $meets->findOne($id)) {
            throw new yiff\stdlib\NoFound;
        }
	$d = $meet->toArray();
	$d['content'] = str_replace('"','&quot;',$d['content']);
        $form->populate($d);

        $this->view->meet = $meet;
        $this->view->page = 'Edycja '.$meet->name;
        if (! $this->_request->isPost()) {
            return;
        }

        $history = new model_meetsHistory;

        $history_item = $history->store($meet);

        $form->populate($_REQUEST);
        
        $meet->update($form->toArray());
        $meet->save() && $history_item->save();
        yiff\stdlib\Service::get('msg')->add('Zmiany zostały zapisane');


    }

    public function indexAction() {
        $this->_redirect(port('/'));
    }

    public function showhistoryAction() {
        $id = $this->_getParam(0);
        $h = new model_meetsHistory;
        $h->users = new model_users;
        if(! $this->view->item = $h->findOne($id)) {
            throw new yiff\stdlib\NoFound;
        }

        $this->view->page = "Historia: ".$this->view->item->getContent()->name." (".$this->view->item->date('date').")";
    }
}
