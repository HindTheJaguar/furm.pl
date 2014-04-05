<?php

/**
 * System EKL
 * 
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2013-10-03, 06:19:14
 * 
 * Opis zmian:
 * 2013-10-03:
 * -Utworzenie pliku
 */

namespace yiff\db\queric;

interface RawInterface
{
    public function getQueryPart();
}
