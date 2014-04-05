<?php
namespace yiff\form\element;
class file extends elementAbstract {

    public function create() {
        return "<input type='file' name='" . $this->name . "'" . $this->_htmlAttr() . ">";
    }

    public function getFileName() {
        return $_FILES[$this->name]['name'];
    }

    public function getFile() {
        $tmp_name = $_FILES[$this->name]["tmp_name"];
        if (!is_uploaded_file($tmp_name)) {
            throw new yiff_form_exception('Upload fail');
        }
        return $tmp_name;
    }
    
    public function move($desc) {
        if (! isset($_FILES[$this->name])) {
            throw new yiff_form_exception('No uploads');
        }
        $tmp_name = $_FILES[$this->name]["tmp_name"];
        if (!is_uploaded_file($tmp_name)) {
            throw new yiff_form_exception('Upload fail');
        }

        if (!move_uploaded_file($tmp_name, $desc)) {
            throw new yiff_form_exception('Moving fail');
        }

        return $this;
    }

}
