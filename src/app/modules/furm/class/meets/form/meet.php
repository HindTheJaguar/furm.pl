<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-07-18, 20:24:56
 */

namespace furm\meets\form;
use yiff\form\element;

class meet extends \yiff\form\form {

    public function init() {
        $this->addElement('text', 'name', [
            'label'=>'Nazwa', 
            'class'=>'form-control'
        ]);

        $el = new element\date('date_start');
        $el->setValue(time());
        $el->setLabel('Data rozpoczęcia');
        $el['class'] = 'form-control';
        $this->setElement($el);

        $el = new element\date('date_end');
        $el->setValue(time());
        $el['class'] = 'form-control';
        $el->setLabel('Data zakończenia');
        $this->setElement($el);

//        $el = new element\select('state');
//        $el->setLabel('Województwo');
//        $el->setOptions(\furm\hyper\states::$states);
////        $el->setOptions(model_furms::$states);
//        $this->setElement($el);

        $el = new element\text('city');
        $el->setLabel('Miasto');
        $el['class'] = 'form-control';
        $this->setElement($el);

        $el = new element\text('info_url');
        $el->setLabel('Adres WWW');
        $el['class'] = 'form-control';
        $this->setElement($el);

        $el = new element\checkbox('private');
        $el->setLabel('Tylko dla zalogowanych');
        $this->setElement($el);

        $el = new element\textarea('content');
        $el->setLabel('Opis');
        $el->setAttr('class', 'wysiwyg form-control');
        $this->setElement($el);

        $this->decorators(['bootstrap']);
        $el = new element\submit('button');
        $el->setIgnore();
        $el->setLabel('Zapisz');
        $this->setElement($el);
    }

}