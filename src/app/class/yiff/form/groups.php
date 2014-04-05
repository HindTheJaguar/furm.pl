<?php

/**
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-01-17, 09:21:01
 */

class yiff_form_groups extends yiff\form\element\elementAbstract {
    
    /**
     * Zawiera listę elementów forumlarza
     * @var array
     */
    protected $_elements = array();
    
    /**
     * Zawiera listę translacji nazw
     * @var array
     */
    protected $_rename = array();
    /**
     *
     * @var EklForm
     */
    public $_form;
    
    public function setup($opt) {
        $this->setIgnore(true);
        if (! ($opt['form'] instanceof form ||$opt['form'] instanceof EklForm)) {
            throw new exception_interface('Wrong form class');
        }
        $this->_form = $opt['form'];
        
        if (isset($opt['elements']) && is_array($opt['elements'])) {
            foreach($opt['elements'] as $v) {
                if (is_string($v)) {
                    $v = $this->_form->$v;
                }
                $this->_elements[$v->name] = $v;
                $v->display = false;
            }
        }
        
        if (isset($opt['rename'])) {
            $this->_rename = $opt['rename'];
        }
        
        if (isset($opt['label'])) {
            $this->label = $opt['label'];
        }
        
    }
    
    public function create() {
        $ret = '';
        foreach($this->_elements as $v) {
            $ret.=$v->decorate();
        }
        return $ret;
    }
    
    public function decorator_tblpart($in) {
        return '<tr><th colspan=2 style="background:#DDF">'.$this->label.'</th></tr>'.$in.'';
    }
    
    public function decorator_label($in) {
        return '<fieldset><legend>'.$this->label.'</legend>'.$in.'</fieldset>';
    }
    
    /**
     *
     * @return array
     */
    public function getValue() {
        $ret = array();
        foreach($this->_elements as $k=>$v) {
            if (isset($this->_rename[$k])) {
                $ret[$this->_rename[$k]]=$v->value;
            } else {
                $ret[$k]=$v->value;
            }
        }
        return $ret;
    }
    
    /**
     *
     * @param array $value
     * @return form_groups 
     */
    public function setValue($value) {
        $rname = array_flip($this->_rename);
        foreach($value as $k=>$v) {
            if (isset($rname[$k])) {
                $this->_elements[$rname[$k]]->setValue($v);
            } else {
                $this->_elements[$k]->setValue($v);
            }
        }
        return $this;
    }
    
}
