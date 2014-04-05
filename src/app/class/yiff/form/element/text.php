<?php


namespace yiff\form\element;
class text extends elementAbstract
{

    public function create()
    {
        return "<input type='text' id='element-" . $this->name . "' name='" . $this->name . "' value='" . $this->value . "'" . $this->_htmlAttr() . ">";
    }

}
