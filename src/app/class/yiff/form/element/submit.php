<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */

namespace yiff\form\element;
class submit extends elementAbstract {
  public function decorator_label($in) {
  return "<div id='field-".$this->name."' class='form-field'>
    <div id='content-".$this->name."' class='form-content'>".$in."</div>
    </div>";
  }

  public function create() {
    return "<input type=submit value='".$this->label."' name='".$this->name."'".$this->_htmlAttr().">";
  }
}
