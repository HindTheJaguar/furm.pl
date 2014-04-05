<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */
namespace furm;
class controller extends \yiff\application\controller {
    /**
     *
     * @var \yiff\view\view
     */
    protected $view;
    protected $_disableView;
    protected $_urlWriter;


    /**
     * @var yiff\helpers\msg
     */
    protected $msg;
    
    public function _preAction() {
        $this->view = new \yiff\view\view(CORE_MODULES_DIR.'/'.$this->_request->getSpace().'/views/'.$this->_request->getController().'/'.$this->_request->getAction().'.php');
        //$this->view->setEngine('furm_view_engine_default');
//        $this->msg = $this->app->getResource('msg');
        $this->_urlWriter = \yiff\stdlib\Registry::get('url_writer');
    }


    public function disableView($disable=true) {
        $this->_disableView = $disable;
        return $this;
    }
    public function _postAction() {
        if (! $this->_disableView) {
            $this->view->exec();
            isset($this->view->page) && \yiff\view\layout::getInstance()->page = $this->view->page;// XXX taki hack na przeniesienie title
        }
    }
    
    /**
     * 
     * @param array $url
     * @param bool $reset
     * @return string
     */
    public function _url($url, $reset = false) {
        if (! $reset) {
            $url = $this->_request->toArray() + $url;
        }
        
        return $this->_urlWriter->url($url);
    }
}
