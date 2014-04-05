<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-07-11, 19:15:11
 */

echo $this->partial('/furm/views/meet/edit_menu.php',array(
    'meet'=>$this->meet,
    'selected'=>'news',
));

echo '<a href="'.port('/meets/news/new/'.$this->meet->id).'">Dodaj Wiadomość</a>';

$this->partial('/meets/views/news/_list.php',array(
    'list'=>$this->list,
))->render();
