<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-08-16, 20:47:36
 */


namespace furm\adm;
class grid {
    public function __construct($mapper, $options = array()) {
        $this->_mapper = $mapper;
    }
    
    public function setColon($colon) {
        $this->_colon = $colon;
    }
    
    public function render() {
        echo '<table><tr>';
        foreach($this->_colon as $vv) {
            echo '<th>'.$vv['name'].'</th>';
        }
        echo '</tr>';
        
        foreach($this->_mapper as $v) {
            echo '<tr>';
            foreach($this->_colon as $vv) {
                echo '<td>';
                
                if (isset($vv['column'])) {
                    echo $v->$vv['column'];
                } elseif (isset($vv['type'])) {
                    if ($vv['type'] == 'options') {
                        echo $this->_options($vv, $v);
                    }
                }
                
                echo '</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
    }
    
    public function _options($opt, $row) {
        $ret = '';
        foreach($opt['links'] as $v) {
            $url = $v['url'];
            
            if (isset($v['replace'])) {
                foreach($v['replace'] as $k=>$vv) {
                    $url = str_replace($k, $row->$vv,$url);
                }
                
            }
            $ret.='<a href="'.$url.'">'.$v['name'].'</a><br />';
        }
        return $ret;
    }
}