<?php

/**
 * System EKL
 * 
 * @author Przemysław 'Hind' Jakubowski <przemyslaw.jakubowski@pkp-cargo.eu>
 * @date 2014-03-03, 08:04:33
 * 
 * Opis zmian:
 * 2014-03-03:
 * -Utworzenie pliku
 */

$this->page = 'Pokój '.$this->room->name;

$i=0;
echo '<ol>';
foreach($this->room->getOccupants() as $occupant) {
    $i++;
    echo '<li>'.$occupant->user_id.'</li>';
}

for (;$i<$this->room->size;$i++) {
    echo '<li>-</li>';
}
echo '</ol>';
