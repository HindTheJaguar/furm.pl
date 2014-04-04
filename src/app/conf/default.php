<?php

$conf = array(
    'cache'=>array (
        'backend'=>'file',
        'dir'=>'c:\\temp',
    ),
    'db' => array(
        'name' => 'live',
        'user' => 'hind',
        'pass' => 'h8',
        'host' => 'localhost',
    ),
    'version' => '2.3',
    'enviroment' => 'DEVELOPMENT', // 'PRODUCTION'
);

if (is_file('/etc/furm.conf.php')) {
    return include '/etc/furm.conf.php';
}
return $conf;
