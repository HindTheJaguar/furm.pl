<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-07-18, 20:16:45
 */

namespace furm\auth\form;
use yiff\form\element;

class lostpass extends \yiff\form\form {

    public function init() {
        $el = new element\text('login');
        $el->setLabel('Login');
        $this->setElement($el);

        $el = new element\submit('button');
        $el->setIgnore();
        $el->setLabel('Wyślij link do resetowania hasła');
        $el->setAttr('style','width:300px');
        $this->setElement($el);
    }

}