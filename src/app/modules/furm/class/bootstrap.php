<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2013-05-04, 21:19:23
 */

namespace furm;

use yiff;
use yiff\stdlib\Registry as registry;

class bootstrap extends yiff\application\bootstrap {

    public function _initConf() {
        $conf = \yiff\conf\factory::fromArray(CORE_DIR . '/conf/default.php');
        registry::set('conf', $conf);
    }

    public function _initMode() {
        if (registry::get('conf')->enviroment == 'DEVELOPMENT') {
            define('IS_PRODUCTION', false);
        } else {
            define('IS_PRODUCTION', true);
            //$this->errorHandler();
        }
        return true;
    }

    public function _initCache() {
        $backend = registry::get('conf')->cache->backend?:'session';
        yiff\cache\cache::setBackend($backend);
        if ($backend === 'file') {
            yiff\cache\backend\file::$dir=registry::get('conf')->cache->dir?:'/temp';
        }
        
        registry::set('default_cache', new yiff\cache\cache($backend));
    }
    
    public function _initTimezone() {
        date_default_timezone_set('Europe/Warsaw');
    }

    public function _initUrlWriter() {
        $uw = new yiff\router\http\url\writer();
        $uw->addMap('default@meet@show', function($url) {
                    return '/meet/show/' . $url['id'];
                });


        registry::set('url_writer', $uw);
    }

    public function _initDB() {
        $conf = registry::get('conf')->db->toArray();
        $db = new \yiff\db\adapter($conf);
        $db->profiler = new \yiff\db\profiler;
        registry::set('db', $db);
        \yiff_db_model_abstract::setDb($db);
    }

    public function _initSession() {
        $this->session = new \yiff_session_db(registry::get('db'));

        session_name('_FurmS');
        if (isset($_COOKIE['_FurmAL']) && session_id() != $_COOKIE['_FurmAL']) {
            setcookie('_FurmAL', $_COOKIE['_FurmAL'], time() + (3600 * 24 * 180), '/');
            session_id(substr($_COOKIE['_FurmAL'], 0, 32));
        }

        session_start();
        $s = new \yiff\session\session();
        registry::set('session', $s);
    }

    public function _initUser() {
        $suser = new \yiff_session_namespace('_user');
        if ($suser->id) {
            $user = new \yiff\auth\User($suser->toArray());
            $user->mail = $suser->mail;
        } else {
            $user = new \yiff\auth\User(array('id' => 0, 'login' => 'anonymous', 'name' => 'Anonymous'));
        }

        registry::set('user', $user);
        return $user;
    }

    public function _initMsg() {
        registry::set('msg', new \yiff\helpers\msg());
    }

    public function _initLayout() {
        \yiff\view\layout::getInstance()->startCapture()
                ->setRenderScript('bootstrap')
                ;
    }

    public function _initConst()
    {
        if (!defined('HTTP_APP_BASE')) {
            define('HTTP_APP_BASE',  rtrim($_SERVER['SCRIPT_NAME'],'/'));
        }
    }
    
    public function _initRouteMap() {
        $route = new \yiff\router\http\routeMatch();

//        $route->addPath('meet', new \yiff\router\http\expr2([
//            'url'=>'/meet/:id',
//        ]));

        $route->addPath('addmeet', new \yiff\router\http\same([
            'url' => '/dodaj-meet',
            'req' => [
                'controller' => 'addmeet',
                'action' => 'index',
                'space' => 'default',
            ],
        ]));
        $route->addPath('user', new \yiff\router\http\expr2([
            'match' => '/^\/users\/(.*[^\/])/',
            'url' => '/users/:name',
            'default' => [
                'controller' => 'users',
                'action' => 'show',
                'space' => 'default',
            ]
        ]));
        $route->addPath('meet', new \yiff\router\http\expr2([
            'match' => '/^\/meet\/(\d+)/',
            'url' => '/meet/:id',
            'default' => [
                'controller' => 'meet',
                'action' => 'show',
                'space' => 'default',
            ]
        ]));

        $route->addPath('default', new \yiff\router\http\standard([
            'modules' => ['home', 'adm', 'rest', 'meets','furm'],
        ]));
        \yiff\router\frontController::getInstance()->setRouteMap($route);
    }
    
    public function _initFrontController()
    {
        $front = \yiff\router\frontController::getInstance();
        if (isset($_REQUEST['node'])) {
            $front->setUrl($_REQUEST['node']);
        } else if (isset($_SERVER['PATH_INFO'])) {
            $front->setUrl($_SERVER['PATH_INFO']);
        } else {
            $front->setUrl('/');
        }
    }

    public function _postLayout() {
        $layout = \yiff\view\layout::getInstance();
        $layout->endCapture();
        $layout->exec();
    }

    public function _postSession() {
        session_write_close();
    }

}
