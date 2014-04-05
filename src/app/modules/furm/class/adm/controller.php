<?php

namespace furm\adm;

use yiff\stdlib\Registry as registry;

class controller extends \yiff\application\controller
{

    public function init()
    {
        \yiff\view\layout::getInstance()->setRenderScript('admin');
        $this->user = registry::get('user');
        if (!$this->user->isAdmin()) {
            throw new \yiff\stdlib\Restricted;
        }
        \yiff\view\layout::getInstance()->user = $this->user;
    }

    public function setActionMenu($actionMenu)
    {
        \yiff\view\layout::getInstance()->actionMenu = $actionMenu;
    }

}
