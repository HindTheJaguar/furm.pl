<?php

/**
 * System EKL
 * 
 * @author Przemysław 'Hind' Jakubowski <przemyslaw.jakubowski@pkp-cargo.eu>
 * @date 2014-05-21, 15:57:10
 * 
 * Opis zmian:
 * 2014-05-21:
 * -Utworzenie pliku
 */
echo $this->list->buildSelect();
foreach($this->list as $v) {
    yiff\helpers\dump::dump($v);
}