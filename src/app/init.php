<?php
define('CORE_DIR',dirname(__FILE__)) ;
define('SCRIPT_START_TIME',microtime(true));
// ścieżka http
$HTTP_ROOT =dirname($_SERVER['SCRIPT_NAME']);
if($HTTP_ROOT!='/') {
    $HTTP_ROOT.='/';
}

define('HTTP_ROOT' , $HTTP_ROOT) ;
unset($HTTP_ROOT); // czyszczenie z niepotrzebnych zmiennych

define('RES_DIR', CORE_DIR.'/res/default/');
define('HTTP_CDN',HTTP_ROOT.'static/');//'http://furm.pl/depot/');//HTTP_ROOT);
define('HTTP_RES',HTTP_ROOT.'static/page/');

define('ROOT',dirname(__FILE__));


include CORE_DIR.'/class/yiff/application/loader.php';
yiff\application\loader::register();
include CORE_DIR.'/functions/common.php';
