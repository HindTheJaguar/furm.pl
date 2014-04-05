<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-12-12, 12:50:42
 */


echo $this->partial('home/views/options.php', array('selected' => 'other'));
$this->page = "Inne opcje";

?>
<ul>
    <li><a href="<?=port('/home/characters')?>">Postacie</a></li>
</ul>