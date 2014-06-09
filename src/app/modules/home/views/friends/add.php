<?php

/**
 * System EKL
 * 
 * @author Przemysław 'Hind' Jakubowski <przemyslaw.jakubowski@pkp-cargo.eu>
 * @date 2014-05-21, 15:25:08
 * 
 * Opis zmian:
 * 2014-05-21:
 * -Utworzenie pliku
 */

switch($this->error) {
    case 'ok':
        echo 'Zaproszenie zostało wysłane';
        break;
    case 'nofound':
        echo 'Próbujesz dodać niesitniejącą osobę';
        break;
    case 'duplicate':
        echo 'Już wysłałeś zaproszenie';
        break;
}