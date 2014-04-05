<?php
namespace yiff\form\element;
class hidden extends elementAbstract {

    public function create() {
        return "<input type='hidden' id='element-" . $this->name . "' name='" . $this->name . "' value='" . $this->value . "'" . $this->_htmlAttr() . ">";
    }

}