<?php
/**
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 14.01.2013
 */

namespace yiff\form\element;
/**
 * Element generatora formularzy odpowiedzialny za pole "Select"
 */
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
        $ret = '<select name="' . $this->name . '"' . $this->_htmlAttr() . '>';
        foreach ($this->options as $k => $v) {
            $ret.= '<option value="' . $k . '"' . (($k == $this->selected) ? ' selected="selected"' : '') . '>' . $v . '</option>';
        }
        $ret.='</select>';
        return $ret;
    }

    public function setValue($value) {
        $this->selected($value);
        parent::setValue($value);
        return $this;
    }
    
    public function setup($opt) {
        if (isset($opt['options'])) {
            $this->setOptions($opt['options']);
        }
        parent::setup($opt);
    }

}
