<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-07-11, 19:14:59
 */


$this->partial('/meets/views/news/_list.php',array(
    'list'=>$this->list,
))->render();