<?php

/**
 * System EKL
 * 
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2014-01-26, 16:10:40
 * 
 * Opis zmian:
 * 2014-01-26:
 * -Utworzenie pliku
 */

namespace furm\planeta\rss;

interface IRss {
    public function getItems();
}