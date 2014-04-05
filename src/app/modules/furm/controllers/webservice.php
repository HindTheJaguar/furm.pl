<?php

/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */
class webserviceController extends \yiff\application\controller
{

    public function indexAction()
    {
        $ss = new SoapServer(null, array(
            'uri' => 'http://yiff.net.pl/furm/ws',
        ));
        $ss->setClass('webservice\index');
        $ss->handle();
    }

    public function rpcAction()
    {
        /*  \yiff\auth\User */
        //$user = $this->get('user');
        
        $server = new jsonRPCServer();
        $server->handle($this);
    }

}
