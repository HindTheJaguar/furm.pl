<?php

/**
 * System EKL
 * 
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2014-02-11, 15:35:34
 * 
 * Opis zmian:
 * 2014-02-11:
 * -Utworzenie pliku
 */

namespace yiff\application;

interface controllerInterface {
    public function dispatch();
    public function setup($params);
}