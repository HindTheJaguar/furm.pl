<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-07-11, 20:52:35
 */

$c = $this->paginator->current();
foreach (range(0,$this->paginator->getMax()) as $page) {
    $name = $page+1;
    if ($page == $c) {
        echo ' [<a href="'.port($this->url,array('page'=>$page)).'">'.$name.'</a>] ';
    } else {
        echo ' <a href="'.port($this->url,array('page'=>$page)).'">'.$name.'</a> ';
    }
}