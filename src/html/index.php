<?php

error_reporting(E_ALL);
$f = dirname(__FILE__);
include $f.'/../app/init.php';

/**
 * Definuje ścieżkę da okatalogu z modułami 
 */
define('CORE_MODULES_DIR',CORE_DIR.'/modules/');
/**
 * definiuje ścieżkę do katalogu publicznego
 */
define('HTTP_ROOT_DIR',$f);
define('CHARACTER_MAIN_DIR', $f.'/static/characters/');
const DEFAULT_MODULE = 'furm';

$app = yiff\application\application::getInstance();
$app->setBootstrap(new furm\bootstrap());
$app->init()
        ->dispatch()
        ->post();

