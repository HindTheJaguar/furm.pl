<?php
namespace furm;
use yiff;
use model_meets;
class addmeetController extends controller {
    public function indexAction() {
        if (yiff\stdlib\Registry::get('user')->isGuest()) {
            throw new yiff\stdlib\Restricted;
        }
        $form = new \furm\meets\form\meet();
        $this->view->form = $form;
        $this->view->page = 'Dodaj nowy meet';
        if (! $this->_request->isPost()) {
            return;
        }

        $form->populate($_REQUEST);
        $data = $form->toArray();
        $data['userid'] = yiff\stdlib\Registry::get('user')->getUid();
        $meets = new model_meets;
        
        yiff\helpers\dump::dump($data);
        try {

            $f = $meets->create($data);
            $f->save();
            yiff\stdlib\Service::get('msg')->add(__('Meet został dodany'));
            $this->_redirect(port('/meet/:id:', array('id'=>$f->id)));
        } catch (\yiff\db\exception $e) {
            throw $e;
        }

    }
}
