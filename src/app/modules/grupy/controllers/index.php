<?php

/**
 * System EKL
 * 
 * @author Przemysław 'Hind' Jakubowski <przemyslaw.jakubowski@pkp-cargo.eu>
 * @date 2014-05-15, 15:22:32
 * 
 * Opis zmian:
 * 2014-05-15:
 * -Utworzenie pliku
 */

namespace grupy;
use yiff;

class indexController extends yiff\application\controller
{
    public function indexAction()
    {
        return 'str';
    }
}