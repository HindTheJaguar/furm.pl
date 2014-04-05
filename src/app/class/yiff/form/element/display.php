<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-07-17, 21:12:05
 */

namespace yiff\form\element;

class display extends elementAbstract
{

    public $displayText;

    public function setup($opt)
    {
        if (isset($opt['text'])) {
            $this->displayText = $opt['text'];
        }
        parent::setup($opt);
    }

    public function create()
    {
        return '<input type=hidden name="' . $this->name . '" value="' . $this->value . '">' . $this->displayText;
    }

}
