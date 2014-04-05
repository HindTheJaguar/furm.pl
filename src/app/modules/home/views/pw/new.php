<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-07-16, 22:12:55
 */
echo $this->partial('home/views/options.php', array('selected' => 'pw'));
echo $this->partial('home/views/pw/menu.php');
echo '<h1>Nowa wiadomość</h1>';
if (isset($this->user) && $this->user) {
    echo "Do: <b>".$this->user.'</b><br>';
} else {
    echo 'Do: <b><a href="'.port('/browse/users').'">Wybierz (wiadomość zostanie skasowana)</a></b><br>';
}
echo $this->form;