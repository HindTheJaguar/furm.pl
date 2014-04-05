<?php

/**
 * System EKL
 * 
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2014-01-26, 16:11:16
 * 
 * Opis zmian:
 * 2014-01-26:
 * -Utworzenie pliku
 */

namespace furm\planeta\rss;
use SimpleXMLElement;
class polfurs implements IRss
{

    /**
     * 
     * @return \furm\planeta\rss\rssPub[]
     */
    public function getItems()
    {
        $pf = file_get_contents('http://www.polfurs.org/modules/newbb/rss.php');

        $pfX = new SimpleXMLElement($pf);

        $m = array();
        foreach ($pfX->channel->item as $v) {
            $x = new rssPub;
            $x->title = (string) $v->title;
            $x->src = 'polfurs';
            $x->desc = (string) $v->description;
            $x->date = (string) $v->pubDate;
            $x->link = (string) $v->link;
            $x->author = (string) $v->author;
            $x->time = strtotime($v->pubDate);
            $m[] = $x;
        }
        
        return $m;
    }

}
