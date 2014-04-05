<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */
namespace furm;

class regulaminController extends controller {
    public function  indexAction() {
        $this->view->page = 'Regulamin';
    }
}