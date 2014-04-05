<?php

/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */
namespace yiff\view\helper;
class action {
    public function action($controller='index', $action = 'index', $module = 'default', $args = array()) {
        $dispatcher = new \yiff_router_dispatcher(array(
            'bootstrap'=> \yiff\application\bootstrap::getInstance(),
            'request'=>new \yiff_router_request(array(
                'controller'=>$controller,
                'action'=>$action,
                'space'=>$module,
                'params'=>$args,
            ))
        ));
        $dispatcher->dispatch();
    }
}