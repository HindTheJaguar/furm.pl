<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2013-05-07, 20:56:48
 */

namespace yiff\view;

class view
{

    protected $_engine;
    protected $_file;

    public function __construct($file = null)
    {
        if (is_string($file)) {
            $this->_file = $file;
        } elseif (is_array($file)) {
            $this->_file = $file['script'];
            foreach ($file['data'] as $k => $v) {
                $this->{$k} = $v;
            }
        }
    }

    public function __set($name, $value)
    {
        if ($name{0} == '_') {
            throw new Exception('Private properity setter', 40);
        }
        $this->{$name} = $value;
    }

    public function __unset($name)
    {
        unset($this->{$name});
    }

    public function setEngine($engine)
    {
        $this->_engine = $engine;
    }

    public function getEngine()
    {
        return $this->_engine;
    }

    public function show()
    {
        ob_start();
        $this->exec();
        $c = ob_get_clean();
        return $c;
    }

    public function getFile()
    {
        if (!$this->_file) {
            return null;
        }
        $file = $this->_file;

        if (!is_file($this->_file)) {
            $this->_file = CORE_DIR . '/res/' . $file;
            
            if (!is_file($this->_file)) {
                $this->_file = CORE_MODULES_DIR .'/'.  $file;
            }
        }



        if (!is_file($this->_file)) {
            throw new Exception('File no found (' . $this->_file . ')');
        }
        return $this->_file;
    }

    public function setFile($file)
    {
        $this->_file = $file;
    }

    public function set($name, $value = null)
    {
        if (is_array($name)) {
            foreach ($name as $k => $v) {
                $this->{$k} = $v;
            }
        } else {
            $this->{$name} = $value;
        }
    }

    public function get($name)
    {
        return $this->{$name};
    }

    public function exec()
    {
        include $this->getFile();
    }

    public function render($file = null)
    {
        $this->exec();
    }

    public function __call($name, $args)
    {
        return actionHelper::call($name,$args);
    }

    public function __toString()
    {
        return $this->show();
    }

}
