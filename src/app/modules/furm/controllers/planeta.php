<?php

/**
 * System EKL
 * 
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2014-01-26, 18:22:16
 * 
 * 2014-01-26:
 * -Utworzenie pliku
 */
namespace furm;
/**
 * Description of planeta
 *
 */
class planetaController extends controller
{

    public function indexAction()
    {
        $this->view->page = 'Planeta';
        $data = \yiff\cache\cache::fetch('planeta');
        if (!$data) {
            $rss = new \furm\planeta\rss;
            $data = $rss->getItems();
            \yiff\cache\cache::store('planeta', $data, 1800);
        }
        $this->view->items = $data;
    }

}
