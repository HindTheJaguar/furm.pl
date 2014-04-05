<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */
namespace furm;
use yiff;

class docController extends controller {
    public function showAction() {
        $id = $this->_getParam(0);
        
        if ($id == 'web_api') {
            $this->view->page = ucFirst(str_replace('_',' ',$id));
            $this->view->content = <<<__DOC__
   Adres do pliku JSON: http://furm.pl/api/json
   
__DOC__;
            return;
        } elseif(! $file = realpath(CORE_DIR.'/common/doc/'.$id.'.txt')) {
            throw new yiff\stdlib\NoFound('File no found', 404);
        }
        $this->view->page = ucFirst(str_replace('_',' ',$id));
        $this->view->content = file_get_contents($file);
        
    }
}