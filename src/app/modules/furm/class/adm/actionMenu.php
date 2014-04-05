<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-08-15, 19:42:23
 */


namespace furm\adm;
class actionMenu {
    protected $items = array();
    
    public function add($id, $name, $url, $icon = null) {
        $this->items[$id]=array('name'=>$name, 'url'=>$url,'icon'=>$icon);
    }
    
    public function del($id) {
        unset($this->items[$id]);
        return $this;
    }
    
    public function render() {
        $i=0;
        $ret='';
        foreach ($this->items as $k=>$v) {
            $ret.='<li class="b'.($i++%2+1).'"><a class="icon '.(isset($v['icon'])?$v['icon']:'view_page').'" href="'.$v['url'].'">'.$v['name'].'</a></li>';
        }
        return $ret;
    }
    
    public function __toString() {
        return $this->render();
    }
}