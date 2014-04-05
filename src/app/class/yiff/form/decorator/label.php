<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */
class yiff_form_decorator_label {
  public function decorate($in, $form) {
    return "<div>
    <div style='float:left;'>".$form->label."</div>
    <div style='margin-left:200px;'>".$in."</div>
    </div>";
  }
}
?>
