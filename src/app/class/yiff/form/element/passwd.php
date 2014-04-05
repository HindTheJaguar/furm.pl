<?php
namespace yiff\form\element;
class passwd extends elementAbstract {

    protected $_ignoreP = false;

    public function create() {
        if ($this->_ignoreP) {
            return "<input ".$this->_htmlAttr()." type='password' name='" . $this->name . "' value=''>";
        } else {
            return "<input ".$this->_htmlAttr()." type='password' name='" . $this->name . "' value='" . $this->value . "'>";
        }
    }

    public function ignorePopulate($ignore = true) {
        $this->_ignoreP = $ignore;
        return $this;
    }

}
