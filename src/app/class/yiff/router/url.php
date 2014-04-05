<?php
/**
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2014-02-10
 * @deprecated klasa wygląda ciulowo
 */
class yiff_router_url
{

    protected $_request;

    public function __construct($request)
    {
        if (!$this->_request = $request) {
            $this->_request = yiff\application\application::getInstance()->getBootstrap()->getResource('request');
        }
    }

    public function url($params, $reset)
    {

        if (!$reset) {
            $r = self::$request->get;
            $params = array_merge($params, $r);
        }


        if (!isset($params['_module'])) {
            $params['_module'] = 'default';
        }

        if (!isset($params['_controller'])) {
            $params['_module'] = 'index';
        }

        if (!isset($params['_action'])) {
            $params['_action'] = 'index';
        }



        foreach ($params as $k => $v) {
            $lnk[] = $k;
            $lnk[] = $v;
        }

        return '/' . implode('/', $lnk);
    }

}
