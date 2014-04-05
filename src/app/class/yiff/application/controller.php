<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-09-23, 21:12:05
 */

namespace yiff\application;
use yiff;
class controller implements controllerInterface {
    /**
     *
     * @var \yiff_router_request
     */
    protected $_request;
    
    /**
     *
     * @var \yiff_router_response
     */
    protected $_response;
    
    public function __construct(array $opts = []) {
        $this->setup($opts);
        $this->init();
    }
    
    public function setup($opts) {
        
        if (isset($opts['request'])) {
            $this->_request = $opts['request'];
        }
    }
    
    public function init() {
        
    }
    
    public function dispatch() {
        
        $action = $this->_request->getAction().'Action';
        if (! method_exists($this, $action)) {
            throw new yiff\stdlib\NoFound('Page no found');
        }
        $this->_preAction();
//        $this->_response->setContent(
        $return =  $this->$action();
        $this->_postAction();
        if ($return instanceof yiff\view\view) {
            if (!$return->getFile()) {
                $return->setFile($this->_request->getSpace().'/'.$this->_request->getController().'/'.$this->_request->getAction().'.php');
            }
            $return->exec();
            if (isset($return->page)) {
                yiff\view\layout::getInstance()->page = $return->page;
            }
            
        } else {
            echo $return;
        }
        
//        if ($this->_response) {
//            $this->_response->setContent($return);
//        } else {
//            return $return;
//        }
    }
    
    protected function _preAction() {
        
    }
    
    protected function _postAction() {
        
    }
    
    public function _getParam($param, $default = null) {
        return $this->_request->getParam($param, $default);
    }
    
    public function _redirect($url, $code = 200, $time = null) {
        header('Location: '.$url);
    }

    public function __call($name, $args) {
        if (substr($name,-6) == 'Action') {
            throw new yiff\stdlib\NoFound('Page '.$name.' no found');
        } else {
            throw new exception('Undefined method '.$name);
        }
    }
    
    public function get($name)
    {
        return yiff\stdlib\Registry::get($name);
    }

}