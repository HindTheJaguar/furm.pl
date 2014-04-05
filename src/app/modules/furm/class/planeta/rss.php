<?php

/**
 * System EKL
 * 
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2014-01-26, 18:00:12
 * 
 * 2014-01-26:
 * -Utworzenie pliku
 */

namespace furm\planeta;

/**
 * Description of rss
 *
 */
class rss
{

    protected $source = array(
        'polfurs', 
        'forg',
        );
    protected $itemsPerPage = 10;

    public function getItems()
    {
        $data = array();
        foreach ($this->source as $src) {
            $class = "\\furm\\planeta\\rss\\".$src;
            $rss = new $class;
            $data=  array_merge($data,(array) $rss->getItems());
        }
        
        $data = $this->sort($data);
        return $data;
    }

    protected function sort($data)
    {
        usort($data, function($l, $r) {

            if ($l->time > $r->time) {
                return -1;
            } else if ($l->time < $r->time) {
                return 1;
            }
            return 0;
        });
        return $data;
    }

}
