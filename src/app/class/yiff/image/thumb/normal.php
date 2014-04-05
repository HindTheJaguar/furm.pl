<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-09-18, 15:20:54
 */


class yiff_image_thumb_normal extends yiff_image_thumb {
    protected $_size = 200;
    public function setSize($size = 200) {
        $this->_size = $size;
    }
    
    public function render() {
        $this->normal($this->_size);
        parent::render();
    }
    
    public function save($file) {
        $this->normal($this->_size);
        parent::save($file);
    }
}