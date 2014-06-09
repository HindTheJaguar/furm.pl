<?php

$conf = array(
    'cache'=>array (
        'backend'=>'file',
        'dir'=>'c:\\temp',
    ),
    'db' => array(
        'name' => 'furm',
        'user' => 'admin2gilenl',
        'pass' => 'QyrRHNaqVakx',
        'host' => 'localhost',
    ),
    'version' => '2.4',
    'enviroment' => 'DEVELOPMENT', // 'PRODUCTION'
);

   $conf['db'] = array(
        'name' => 'live',
        'user' => 'hind',
        'pass' => 'h8',
        'host' => 'localhost',
       );
return $conf;