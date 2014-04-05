<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-07-10, 18:37:46
 */

namespace furm\common\user;
trait actions {
    function getUrl() {
        return \port('/users/:login:',array('login'=>$this->login));
    }
    
}