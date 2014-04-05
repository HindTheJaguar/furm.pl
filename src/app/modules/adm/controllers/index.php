<?php
namespace adm;

class indexController extends controller {
    protected $modules = array(
        array('name'=>'Newsy', 'url'=>'adm/news'),
    );
    public function indexAction() {
        $am = new actionMenu();
        $this->setActionMenu($am);
        
        $am->add('news', 'Wiadomości', '#');
        foreach($this->modules as $v) {
            echo '<a href="index.php?node='.$v['url'].'">'.$v['name'].'</a><br>';
        }
    }
}
