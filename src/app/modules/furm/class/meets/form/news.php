<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-07-11, 19:32:08
 */

namespace furm\meets\form;

class news extends \yiff\form\form {

    public function init() {
        $this->addElement('text','name',array(
            'label'=>'Tytuł',
        ));
        
        $this->addElement('textarea','content',array(
            'attr'=>[
                'class'=>'form-control wysiwyg'
            ],
            'label'=>'Treść wiadomości',
        ));
        
        $this->addElement('submit','button',array(
            'label'=>'Zapisz',
            'ignore'=>true,
        ));
    }

}