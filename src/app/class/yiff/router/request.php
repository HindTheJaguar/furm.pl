<?php

/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 */
use yiff\application\application as app;

class yiff_router_request implements yiff\stdlib\toArray
{

    public $_action, $_controller, $_space, $_params = [], $get = [];
    protected $_session;

    public function __construct(array $params = array())
    {
        $this->setup($params);
    }

    public function setup($params)
    {
        if (isset($params['controller']) && $params['controller']) {
            $this->_controller = $params['controller'];
        } else {
            $this->_controller = 'index';
        }

        if (isset($params['action']) && $params['action']) {
            $this->_action = $params['action'];
        } else {
            $this->_action = 'index';
        }

        if (isset($params['space']) && $params['space'] <> 'default') {
            $this->_space = $params['space'];
        } else {
            $this->_space = \DEFAULT_MODULE; //'default';
        }

        if (isset($params['params'])) {
            $this->_params = $params['params'];
        } else {
            $this->_params = array();
        }

        if (isset($params['get_params'])) {
            $this->get = $params['get_params'];
            $this->_params = $this->_getParams + $this->get;
            $this->get['_module'] = $this->_space;
            $this->get['_action'] = $this->_action;
            $this->get['_controller'] = $this->_controller;
        }
    }

    public function getController()
    {
        return $this->_controller;
    }

    public function getAction()
    {
        return $this->_action;
    }

    public function getSpace()
    {
        return $this->_space;
    }

    public function getParam($param, $default = null)
    {
        if (isset($this->_params[$param])) {
            return $this->_params[$param];
        }
        return $default;
    }

    public function getNamedParam($param, $default = null)
    {
        $id = array_search($param, $this->_params);
        if ($id === false) {
            return null;
        }
        
        $id++;
        return $this->getParam($id, $default);
    }

    /**
     * Zwraca wszystkie argumenty
     * @return array
     */
    public function getAllParams()
    {
        return $this->_params;
    }

    public function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    public function toArray()
    {
        return $this->_params + array('module' => $this->_space);
    }

    /**
     * 
     * @return yiff\session\session
     */
    public function getSession()
    {
        return app::getInstance()->getBootstrap()->getResource('session');
    }

    public function populateFromGlobals()
    {
        $this->_params = $this->_params + (array) $_REQUEST;
    }

}
