<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-07-11, 19:52:19
 */
try {
foreach ($this->list as $news) {
    $this->partial('/meets/views/news/show.php',['news'=>$news])->render();
    echo '<hr>';
}
} catch(\yiff\stdlib\NoFound $e) {
    echo '<div style="border:solid 1px black; background-color: orange; padding: 10px; text-align:center;">Brak wiadomości</div>';
}