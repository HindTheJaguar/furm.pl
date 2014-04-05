<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */

namespace yiff\db;
class expr {
    public $value;
    public function  __construct($value) {
        $this->value = $value;
    }

    public function __toString() {
        return $this->value;
    }
}
