<?php

/**
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 14.01.2013
 */

namespace yiff\form\element;
class select extends elementAbstract {

    public $name;
    public $selected;
    public $options;

    public function selected($index) {
        $this->selected = $index;
        return $this;
    }

    public function setOptions($opt) {
        $this->options = $opt;
        return $this;
    }

    public function create() {
        $ret = '';
        foreach ($this->options as $k => $v) {
            $ret.= '<input type="radion" id="element-radio-' . $this->name . '-' . $k . '" name="' . $this->name . '" value="' . $k . '"' . (($k == $this->selected) ? ' selected="selected"' : '') . $this->_htmlAttr() . '> <label for="element-radio-' . $this->name . '-' . $k . '">' . $v . '</label>';
        }

        return $ret;
    }

    public function setValue($value) {
        $this->selected($value);
        parent::setValue($value);
        return $this;
    }

}
