<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-07-11, 19:12:12
 */

namespace meets;

use furm;
use yiff;
use furm\meets\model\news as news;
use furm\meets\model\meet as meet;

class newsController extends furm\controller
{

    public function _preAction()
    {
        parent::_preAction();
        $this->view->page = 'News';
    }

    public function indexAction()
    {
        $this->view->list = news::model()->fetchAll([], 'id DESC');
    }

    public function listAction()
    {
        $this->view->meet = meet::model()->findOne((int) $this->_request->getParam('0'));
        $this->view->list = news::model()->fetchAll(
                ['meet_id = ?' => (int) $this->_request->getParam('0')]
                ,'id DESC');
    }

    public function showAction()
    {
        $this->view->news = news::model()->findOne((int) $this->_request->getParam('0'));
    }

    public function editAction()
    {
        if (!uid())
            throw new yiff\stdlib\Restricted;
        $this->view->form = new \furm\meets\form\news;
    }

    public function newAction()
    {
        if (!uid())
            throw new yiff\stdlib\Restricted;
        $id = (int) $this->_request->getParam('0');
        $this->view->meet = $meet = \model_meets_entity::model()->findOne($id);
        $form = $this->view->form = new \furm\meets\form\news;
        if (!$this->_request->isPost()) {
            return;
        }

        $data = $form->populate($this->_request->getAllParams())->getValues();
        $data['user_id'] = uid();
        $data['meet_id'] = $meet->id;
        $news = news::model()->create($data);
        $news->save();
        $this->_redirect($news->getUrl());
    }

}
