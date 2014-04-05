<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-07-18, 20:13:45
 */
namespace furm\auth\form;

use yiff\form\element;

class register extends \yiff\form\form {

    public function init() {
        $this->setAction('/');
        $el = new element\text('login');
        $el->setLabel('Login');
        $el['class']='form-control';
        $this->setElement($el);

        $el = new element\passwd('passwd');
        $el->setLabel('Hasło');
        $el['class']='form-control';
        $this->setElement($el);

        $el = new element\passwd('passwd2');
        $el->setLabel('Powtórz hasło');
        $el['class']='form-control';
        $this->setElement($el);

        $el = new element\text('mail');
        $el->setLabel('EMail');
        $el['class']='form-control';
        $this->setElement($el);

        $el = new element\text('name');
        $el->setLabel('Nazwa');
        $this->setElement($el);
        $el['class']='form-control';
        $this->decorators(['bootstrap']);
        $el = new element\submit('button');
        $el->setLabel('Rejestruj');
        $el->setIgnore();
        $this->setElement($el);
    }

}