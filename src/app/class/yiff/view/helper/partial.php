<?php

/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */
namespace yiff\view\helper;
use yiff\view\view;
class partial {
    public function partial($script, $args = array()) {
         return new view(array(
            'script'=>$script,
            'data'=>$args,
            ));
    }
}