<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-07-18, 20:06:13
 */

namespace furm\auth\form;

use yiff\form\element as E;

class login extends \yiff\form\form
{

    public function init()
    {
        $el = new E\text('login');
        $el->setLabel('Login');
        $this->setElement($el);

        $el = new E\passwd('passwd');
        $el->setLabel('Hasło');
        $this->setElement($el);

        $el = new E\submit('button');
        $el->setIgnore();
        $el->setLabel('Zaloguj');
        $this->setElement($el);
    }

}
