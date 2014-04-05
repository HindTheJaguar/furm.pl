<?php

/**
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2014-02-10
 */

namespace yiff\view;

class layout
{

    protected $view;
    protected $_content;
    protected $_disable;
    protected $_renderScript = 'default';
    static protected $_instance;

    /**
     * @return yiff\view\layout
     */
    static public function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    public function __construct()
    {
        
    }

    public function setView(view $view)
    {
        $this->view = $view;
    }

    /**
     * 
     * @return \yiff\view\layout
     */
    public function startCapture()
    {
        ob_start();
        return $this;
    }

    public function endCapture()
    {
        $this->_content.=ob_get_clean();
    }

    public function reset()
    {
        $this->_content = '';
    }

    public function getContent()
    {
        return $this->_content;
    }

    public function setContent(view $content)
    {
        $this->_content = $content;
    }

    public function exec()
    {
        if ($this->_disable) {
            return;
        }
        include RES_DIR . '../_layout/' . $this->_renderScript . '.php'; //default.php';
    }

    public function disable($disable)
    {
        if ($disable) {
            $this->endCapture();
            ob_end_clean();
        }
        $this->_disable = $disable;
    }

    public function setRenderScript($name = 'default')
    {
        $this->_renderScript = $name;
        return $this;
    }

}
