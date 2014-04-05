<?php

/**
 * System EKL
 * 
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2014-01-29, 20:40:56
 * 
 * 2014-01-29:
 * -Utworzenie pliku
 */


class yiff_form_decorator_bootstrap {
  public function decorate($in, $form) {
     return '<div class="form-group">
    <label for="element-' . $form->name . '">'.$form->label.'</label>
    '.$in.'
  </div>';
  }
}
