<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @author hind
 */

$cl = '/home/hind/public_html/live/app';
define('CORE_DIR', $cl);
ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.$cl.'/class');
include 'yiff/application/loader.php';
yiff\application\loader::register();
