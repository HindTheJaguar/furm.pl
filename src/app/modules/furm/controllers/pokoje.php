<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */

class pokojeController extends furm\controller {
    /**
     *
     * @var model_pokoje
     */
    public $pokoje;

    /**
     *
     * @var access
     */
    public $access;

    public function init() {
        $this->pokoje = yiff\stdlib\Service::get('model_pokoje');
        $this->access = \yiff\stdlib\Registry::get('user');
        if ($this->access->isGuest()) {
            e('access denided',403);
        }
    }

    public function meetAction() {
        $id = (int) $this->_getParam('0');
        if(! $meet = yiff\stdlib\Service::get('model_meets')->findOne($id)) {
            throw new exception('File no found',404);
        }
        $this->view->meet = $meet;
        $this->view->page = 'Pokoje: '.$meet->name;


        $this->view->pokoje = $this->pokoje->findByMeet($meet);

    }

    public function edycjaAction() {
        if(! $pokoj = $this->pokoje->findOne($this->_getParam(0))) {
            e('File no found',404);
        }

        $this->view->page = 'Edycja pokoju';
        $this->view->pokoj = $pokoj;
        $form = $this->view->form = $this->getForm();
        $form->populate($pokoj->toArray());

        if (! $this->_request->isPost()) {
            return;
        }

        $form->populate($_REQUEST);
        $pokoj->update($form->getValues());
        $pokoj->save();
        yiff\stdlib\Service::get('msg')->add('Pokój zmieniony', yiff\helpers\msg::E_SUCCESS, yiff\helpers\msg::T_FLASH);
        $this->_redirect(port('/pokoje/meet/:id:',array('id'=>$pokoj->meet_id)));



    }

    public function dodajAction() {
        $id = (int) $this->_getParam('0');
        if(! $meet = yiff\stdlib\Service::get('model_meets')->findOne($id)) {
            throw new exception('File no found',404);
        }
        $this->view->page = 'Dodawanie pokoju do '.$meet->name;
        $this->view->form = $form = $this->getForm();
        $this->view->meet = $meet;

        if (! $this->_request->isPost()) {
            return;
        }

        $data = $form->populate($_REQUEST)->getValues();
        $data['meet_id'] = $meet->id;
        $data['user_id'] = $this->access->loggedId();
        $this->pokoje->insert($data);
        yiff\stdlib\Service::get('msg')->add('Pokój został dodany', yiff\helpers\msg::E_SUCCESS, yiff\helpers\msg::T_FLASH);
        $this->_redirect(port('/pokoje/meet/:id:',array('id'=>$meet->id)));
    }

    public function getForm() {
        $form = new form();

        $el = new yiff\form\element\text('name');
        $el->setLabel('Nazwa pokoju');
        $form->setElement($el);

        $el = new yiff\form\element\text('miejsc');
        $el->setLabel('Ilość miejsc');
        $form->setElement($el);

        $el = new yiff\form\element\submit('button');
        $el->setLabel('Dodaj pokuj')->setIgnore();
        $form->setElement($el);

        return $form;
    }
}
