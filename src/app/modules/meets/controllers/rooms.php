<?php

/**
 * System EKL
 * 
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2014-02-14, 05:56:46
 * 
 * Opis zmian:
 * 2014-02-14:
 * -Utworzenie pliku
 */

namespace meets;

use furm;
use yiff;

/**
 * Każda osoba może być zameldowana w kilku pokojach
 * Tworząc pokój należy określić:
 * -nazwę
 * -numer
 * -ilość miejsc
 * -grupę/standard
 */
class roomsController extends furm\controller
{

    protected $_meet;

    public function _preAction()
    {
        if (!uid()) {
            throw new yiff\stdlib\Restricted;
        }
        parent::_preAction();
        $this->_getMeet();
    }

    /**
     * Dodawanie nowego pokoju
     */
    public function addAction()
    {
        $form = new rooms\newRoomForm;
        $this->view->form = $form;

        if (!$this->_request->isPost()) {
            return;
        }

        $form->populate($this->_request);
        $data = $form->toArray();
        $data['meet_id'] = $this->_getMeet()->id;
        $id = rooms\rooms::model()->insert($data);


        $url = yiff\stdlib\Registry::get('url_writer')->url([
            '_action' => 'room',
            '_controller' => 'rooms',
            '_module' => 'meets',
            'id' => $this->_getMeet()->id,
            'room' => $id,
        ]);
        $this->_redirect($url);
    }

    /**
     * Usuwanie dodawanego pokoju
     */
    public function deleteAction()
    {
        
    }

    /**
     * Przyłączanie się do pokoju
     */
    public function joinAction()
    {
        $this->disableView();
        $id = $this->_getMeet()->id;

        try {
            $occupant = rooms\rooms::model()[$this->_request->getNamedParam('room')]->join(uid());
        } catch (yiff\stdlib\NoFound $e) {
            $this->_redirect(yiff\stdlib\Registry::get('url_writer')->url([
                        '_action' => 'list',
                        '_controller' => 'rooms',
                        '_module' => 'meets',
                        'id' => $this->_getMeet()->id,
                        'msg' => 'no_room'
            ]));
            return;
        }
        $this->_redirect(yiff\stdlib\Registry::get('url_writer')->url([
                    '_action' => 'list',
                    '_controller' => 'rooms',
                    '_module' => 'meets',
                    'id' => $this->_getMeet()->id,
                    'msg' => 'joined'
        ]));
        return;
    }

    /**
     * opuszcczanie pokoju
     */
    public function leaveAction()
    {
        $this->disableView();
        $occupation = rooms\occupants::model()->fetchRow([
            'user_id = ?' => uid(),
            'room_id = ?' => $this->_request->getNamedParam('room'),
        ]);

        if (!$occupation) {
            $this->_redirect(yiff\stdlib\Registry::get('url_writer')->url([
                        '_action' => 'list',
                        '_controller' => 'rooms',
                        '_module' => 'meets',
                        'id' => $this->_getMeet()->id,
                        'msg' => 'no_occupation'
            ]));
            return;
        }

        $occupation->delete();

        $this->_redirect(yiff\stdlib\Registry::get('url_writer')->url([
                    '_action' => 'list',
                    '_controller' => 'rooms',
                    '_module' => 'meets',
                    'id' => $this->_getMeet()->id,
                    'msg' => 'leave'
        ]));
        return;
    }

    /**
     * lista pokojów
     */
    public function listAction()
    {
        $id = $this->_getMeet()->id;
        $this->view->users = new \model_users;
        $this->view->user = \yiff\stdlib\Registry::get('user');
        $this->view->rooms = rooms\rooms::model()->fetchAll(['meet_id = ?' => $id],'room_nr');
    }

    /**
     * Pokoik
     */
    public function roomAction()
    {
        $this->view->room = rooms\rooms::model()[$this->_request->getNamedParam('room')];
    }

    protected function _getMeet()
    {
        if (!$this->_meet) {
            $id = $this->_request->getNamedParam('id');
            if (!$id) {
                $id = $this->_request->getParam(0);
            }
            $this->_meet = \furm\meets\model\meet::model()->findOne($id);
            $this->view->meet = $this->_meet;
        }

        return $this->_meet;
    }

}
