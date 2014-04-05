<?php

/**
 * System EKL
 * 
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2014-01-26, 16:11:51
 * 
 * Opis zmian:
 * 2014-01-26:
 * -Utworzenie pliku
 */

namespace furm\planeta\rss;
use SimpleXMLElement;
class forg implements IRss
{
   protected $mon = array('sty' => 1,
            'lut' => 2,
            'mar' => 3,
            'kwi' => 4,
            'maj' => 5,
            'cze' => 6,
            'lip' => 7,
            'sie' => 8,
            'wrz' => 9,
            'paź' => 10,
            'lis' => 11,
            'gru' => 12);
    protected function forgdate($date)
    {
        //'So, 25 sty 2014 15:50:06 GMT'
        if (preg_match('/^(.*), (\d+) (.*) (\d+) (\d+):(\d+):(\d+) GMT$/i', $date, $o)) {
            $time = mktime($o[5], $o[6], $o[7], $this->mon[strtolower($o[3])], $o[2], $o[4]);
            return $time;
        }
        return time();
    }

    public function getItems()
    {
        $forg = file_get_contents('http://futrzaki.org/rss.php');

        $forgX = new SimpleXMLElement($forg);

        foreach ($forgX->channel->item as $v) {
            $x = new rssPub;
            $x->title = (string) $v->title;
            $x->src = 'forg';
            $x->desc = (string) $v->description;
            $x->date = (string) $v->pubDate;
            $x->link = (string) $v->link;
            $x->author = (string) $v->author;
            $x->time = $this->forgdate($v->pubDate);
            $m[] = $x;
        }
        return $m;
    }

}
