<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-07-16, 20:24:16
 */


namespace furm\pw\form;
class pw extends \yiff\form\form {
    public function init() {
        $this->addElement('text', 'topic', array(
            'label'=>'Tytuł',
        ));;
        
        $this->addElement('textarea', 'body', array(
            'label'=>'Wiadomość',
            'attr'=>[
                'style'=>'width:450px; height:120px;',
            ]
        ));
        
        $this->addElement('submit', 'button', array(
            'ignore'=>true,
            'label'=>'Wyślij',
        ));
    }
}