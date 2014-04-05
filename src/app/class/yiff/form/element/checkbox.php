<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @package
 * @subpackage
 * @date 2011-01-011
 */

namespace yiff\form\element;

class checkbox extends elementAbstract
{

    public $value = 0;
    protected $default = 1;
    protected $defaultEmpty = 0;

    public function create()
    {
        return "<input type='hidden' name='" . $this->name . "' value='" . $this->defaultEmpty . "'>" .
                "<input type='checkbox' id='input-" . $this->name . "' name='" . $this->name . "' value='" . $this->default . "'" . $this->_htmlAttr() . ">"
        ;
    }

    public function setValue($value)
    {
        if ($value == $this->default) {
            $this->setAttr('checked', 'checked');
            parent::setValue($value);
        } else {
            $this->unsetAttr('checked');
            parent::setValue($this->defaultEmpty);
        }
    }

    public function setDefaultValue($value)
    {
        $this->default = $value;
        return $this;
    }

    public function setDefaultEmpty($value = 0)
    {
        $this->value = $value;
        $this->defaultEmpty;
        return $this;
    }

    public function decorator_inline($in)
    {
        return "" . $in . " <label for='input-" . $this->name . "'>" . $this->label . "</label> ";
    }
    
    
    public function decorator_bootstrap($in)
    {
             return '<div class="checkbox">
    <label for="element-' . $this->name . '">'.$in.' '.$this->label.'</label>
    
  </div>';
    }

}
