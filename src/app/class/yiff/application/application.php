<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2013-05-04, 21:35:32
 */

namespace yiff\application;

use Exception;
use yiff\router;
use yiff;

class application
{

    protected static $_instance;
    protected $bootstrap;

    /**
     * 
     * @return \yiff\application\application
     */
    public static function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    protected function __construct()
    {
        ;
    }

    /**
     * 
     * @param bootstrap $bootstrap
     * @return app
     */
    public function setBootstrap(bootstrap $bootstrap)
    {
        $this->bootstrap = $bootstrap;
        return $this;
    }

    public function init()
    {
        $this->bootstrap->init();
        $this->errorHandler();
        return $this;
    }

    public function post()
    {
        $this->bootstrap->post();
        return $this;
    }

    public function getBootstrap()
    {
        return $this->bootstrap;
    }

    public function dispatch()
    {
        $router = yiff\router\frontController::getInstance();
        $request = $router->getRequest();
        $request->populateFromGlobals();
        //return $this;
        $dispatcher = new \yiff_router_dispatcher(array(
            'request' => $request,
            'bootstrap' => $this,
        ));

        try {
            $dispatcher->dispatch();
        } catch (Exception $e) {
            $module = new router\errorController();
            $module->setError($e);
            $module->setApp($this);
            $module->dispatch();
        }
        return $this;
    }

    public function errorHandler()
    {
        if (\IS_PRODUCTION) {

            function handleFatalPhpError()
            {
                $last_error = error_get_last();
                if ($last_error['type'] === \E_ERROR || $last_error['type'] === \E_USER_ERROR) {
                    echo 'Błąd składni';
                }
            }

            register_shutdown_function('handleFatalPhpError');
        }
    }

}
