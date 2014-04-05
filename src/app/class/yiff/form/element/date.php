<?php

/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */

namespace yiff\form\element;

class date extends elementAbstract
{

    public function create()
    {
        if ($this['class']) {
            $this['class'] = $this['class']." datefield";
        } else {
            $this['class']="datefield";
        }
        return '<input '.$this->_htmlAttr().' type=text size="16" name="'.$this->name.'" value="'.date('Y-m-d', $this->value).'">';
    }

    public function setValue($v)
    {
        if (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/',$v,$o)) {
            $v = strtotime($o['1'] . '-' . $o['2'] . '-' . $o['3'] . ' 12:00:00');
        } elseif (!is_numeric($v)) {
            $v = strtotime($v);
        } 

        return parent::setValue($v);
    }
    
    public function getValue()
    {
        return \yiff\stdlib\DateTime::createFromTimestamp($this->value);
    }

}
