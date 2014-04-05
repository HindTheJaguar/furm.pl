<?php

/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */
class yiff_router_response {
    protected $_content;
    public function setContent($content) {
        $this->_content = $content;
    }
    
    public function setHeader($name, $value) {
        if(! headers_sent()) {
            header($name.': '.$value);
        }
    }
    
    public function setCookie($name, $value = null, $time = null) {
        setcookie($name, $value, (time()+(int)$time), '/');
        return $this;
    }
    
    public function getContent() {
        return $this->_content;
    }
}
