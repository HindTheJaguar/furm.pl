<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2013-05-12, 21:42:19
 */
namespace yiff\router\http;

class routeMatch {

    public function match($url) {
        $r = $this->_match($url);
        $req = new \yiff_router_request;
        if (!$r) {
            return $req;
        }
      
        $p = $r->getParams();
        $x = array(
            'controller'=>$p['controller'],
            'action'=>$p['action'],
            'space'=>$p['space'],
        );
        unset($p['controller'],$p['space'],$p['action']);
        $x['params'] = $p;
        $req->setup($x);
        
        return $req;
    }
    
    protected function _match($url) {
        foreach ($this->_routes as $route) {
            if ($route->match($url)) {
                return $route;
            }
        }
    }

    public function addPath($name, $path) {
        $this->_routes[$name] = $path;
    }
    
}