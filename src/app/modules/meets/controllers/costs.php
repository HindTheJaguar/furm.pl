<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-03-16, 19:36:26
 */

namespace meets;

use furm;
use yiff;

class costsController extends furm\controller
{

    protected $_meet;

    /**
     * @var access
     */
    protected $_access;

    public function init()
    {
        if ($this->_request->getAction() != 'index') {
            $this->_access = \yiff\stdlib\Registry::get('user');
            if ($this->_access->isGuest()) {
                throw new yiff\stdlib\Restricted;
            }
        }
    }

    public function indexAction()
    {
        $this->view->page = 'Koszty';
        $this->view->meet = $meet = $this->getMeet();
        /* @var $costs model_meetsCost */
        $costs = yiff\stdlib\Service::get('model_meetsCost');
        $this->view->list = $costs->fetchAll(array(
            'meet_id = ?' => $meet->id,
        ));
    }

    public function addAction()
    {
        $meet = $this->getMeet();
        $cost = yiff\stdlib\Service::get('model_meetsCost');

        $this->view->form = $form = $this->getForm();
        $form->populate(array(
            'cost' => '0.00',
        ));
        if (!$this->_request->isPost()) {
            return;
        }

        $form->populate($_REQUEST);
        $data = $form->getValues();
        $data['cost'] = (float) preg_replace('/[^\d.]/', '', str_replace(',', '.', $data['cost']));
        $data['meet_id'] = $meet->id;
        $data['user_id'] = $this->_access->getUid();
        $cost->insert($data);

        header('location: ' . port('/meets/costs/index/' . $meet->id));
    }

    public function editAction()
    {
        $this->view->cost = $cost = \yiff\stdlib\Service::get('model_meetsCost')->findOne($this->_getParam(1));
        $meet = $this->getMeet();
        $this->view->form = $form = $this->getForm();

        $form->populate($cost->toArray());

        if (!$this->_request->isPost()) {
            return;
        }

        $form->populate($_REQUEST);
        $data = $form->getValues();
        $data['cost'] = (float) str_replace(',', '.', preg_replace('/[^\d.]/', '', $data['cost']));

        $data['user_id'] = $this->_access->getUid();
        $cost->update($data);
        $cost->save();
        header('location: ' . port('/meets/costs/index/' . $meet->id));
    }

    public function deleteAction()
    {
        if (!$cost = yiff\stdlib\Service::get('model_meetsCost')->findOne($this->_getParam(1))) {
            throw new yiff\stdlib\NoFound;
        }
        $id = $cost->meet_id;
        $cost->delete();
        $this->disableView();
        header('Location: ' . port('/meets/costs/index/' . $id));
    }

    /**
     *
     * @return model_meets_entity
     */
    public function getMeet()
    {
        if (!$this->_meet) {
            $this->view->meet = $this->_meet = yiff\stdlib\Service::get('model_meets')->findOne($this->_getParam(0));
        }

        if (!$this->_meet) {
            throw new yiff\stdlib\NoFound;
        }

        return $this->_meet;
    }

    public function getForm()
    {
        $form = new yiff\form\form;

        $el = new yiff\form\element\text('name');
        $el->setLabel('Nazwa');
        $form->setElement($el);

        $el = new yiff\form\element\text('cost');
        $el->setLabel('Koszt');
        $form->setElement($el);

        $el = new yiff\form\element\textarea('info');
        $el->setLabel('Opis');
        $el['class'] = 'wysiwyg form-control';
        $form->setElement($el);

        $el = new yiff\form\element\checkbox('multiselect');
        $el->setLabel('Koszt wielokrotny');
        $form->setElement($el);

        $el = new yiff\form\element\submit('button');
        $el->setLabel('Zapisz')
                ->setIgnore();
        $form->setElement($el);

        return $form;
    }

}
