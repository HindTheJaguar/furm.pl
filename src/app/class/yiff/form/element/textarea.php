<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */
namespace yiff\form\element;
class textarea extends elementAbstract {
  public function  create() {
      
    return "<textarea".$this->_htmlAttr()." id='element-".$this->name."' name='".$this->name."'>".$this->value.'</textarea>';
  }
}
