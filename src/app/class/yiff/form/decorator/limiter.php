<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 */
class yiff_form_decorator_limiter {
  public function decorate($in, $form) {
    return str_replace('onkeyup="{limiter}"',"onkeyup=\"document.getElementById('limiter-".$form->name."').innerHTML = ''+(".$form->getOpt('limiter')."-this.value.length)\"",$in)."<br />
      <div>(Pozostało znaków
      <span id='limiter-".$form->name."'>".($form->getOpt('limiter') - strlen($form->getValue()))."</span>)
      </div>
        ";
  }
}
