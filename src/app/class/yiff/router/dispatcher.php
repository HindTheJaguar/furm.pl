<?php

/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */
class yiff_router_dispatcher {

    /**
     *
     * @var yiff_router_request
     */
    protected $request;
    /**
     *
     * @var yiff_router_response
     */
    protected $response;
    /**
     *
     * @var yiff\application\bootstrap
     */
    protected $bootstrap;
    public function __construct(array $params = array()) {
        $this->setup($params);
    }

    public function setup($params) {
        $this->request = $params['request'];
        $this->bootstrap = $params['bootstrap'];
    }

    public function dispatch() {
        $data = $this->request;
        $dir = CORE_MODULES_DIR;
        $controller = $data->getController();
        $space = $data->getSpace();//['space'];
        $file = realpath($dir . $space . '/controllers/' . $controller . '.php');

        $controller2 = str_replace('-', '_', $controller) . 'Controller';


        if ($file) {
            require $file;
            if ($space != 'default') {
                $controller2 = $space . '\\' . $controller2;
            }
            $module = new $controller2(array(
                        'bootstrap' => $this->bootstrap,
                        'controller' => $controller,
                        'request'=> $data,
                        'space' => $space,
                        'response' => $this->response,
                    ));
            $module->dispatch();
        } else {
            throw new \yiff\stdlib\NoFound('File no found', 404);
        }
    }

}