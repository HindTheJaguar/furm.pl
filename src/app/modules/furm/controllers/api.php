<?php

/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */
namespace furm;
use yiff;
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache");
header("Expires: -1");

yiff\view\layout::getInstance()->disable(true);
use yiff\cache\cache;
class apiController extends \yiff\application\controller
{

    public function _getJson()
    {
        $success = null;
        $cache = cache::fetch('furm.json', $success);
        if ($success) {
            return $cache;
        }
        $db = yiff\stdlib\Service::get('db');
        $rQ = $db->query('select id, name, date_start, date_end from meets where date_end > now() order by date_start ASC');
        $fl = array();
        while ($row = $rQ->fetch()) {
            $r = array();
            if ($row['date_start'] == $row['date_end'])
                $r['date_string'] = 'dnia ' . substr($row['date_start'], 0, 10);
            else
                $r['date_string'] = 'od ' . substr($row['date_start'], 0, 10) . ' do ' . substr($row['date_end'], 0, 10);

            $r['href'] = port('/meet/:id:/:name:', array('id' => $row['id'], 'name' => urlchr($row['name'])));
            $r['name'] = $row['name'];

            $fl[] = $r;
        }

        $data = json_encode($fl);
        cache::store('furm.json', $data, 60);
        return $data;
    }

    public function forgAction()
    {
        $success = null;
        $data = cache::fetch('module.api.forg', $success);
        if ($success) {
            header('Content-Type: text/plain;charset=utf-8');
            echo $data;
            return;
        }

        ob_start();
        $this->purejsAction();

        echo "\n";

        $url = port('/');
        echo <<<EOT
var furmWindow = document.getElementById('furm-window');
var furmTMPHtml = '';

if (furmWindow) {
/*  if(furmFLCount > 0) {*/
  for( i in furmList) {
    furmTMPHtml+='<li><a href="'+furmList[i].href+'">'+furmList[i].name+'</a><br>'+furmList[i].date_string+'</li>';
  }

  furmWindow.innerHTML='<ul>'+furmTMPHtml+'</ul><div id="furm-window-add"><a href="{$url}" title="Dodaj meet na furm.pl">Dodaj Meet</a></div>';
/*  } else{
  furmWindow.innerHTML='<a href="{$url}" title="Dodaj meet na furm.pl">Dodaj Meet</a>';
  }*/

} else {
/*
alert('brak okna');
*/
}

EOT;
        $data = ob_get_clean();
        cache::store('module.api.forg', $data, 60);
        echo $data;
    }

    public function purejsAction()
    {
        header('Content-Type: text/plain;charset=utf-8');
        $time = time();
        echo <<<EOF
  /* $time */
var furmList =
EOF;
        $this->jsonAction();
        echo ';';
        echo "\n";

        $url = port('/index');
        echo <<<EOT
var furmUrl = '{$url}';
EOT;
    }

    public function jsAction()
    {
        echo 'var furm = ';
        $this->jsonAction();
    }

    public function jsonAction()
    {
        echo $this->_getJson();
    }

    public function meetimgAction()
    {
        $rQ = yiff\stdlib\Service::get('db')->query('select * from meets where date_end > now() order by date_start asc LIMIT 4');
        $fl = array();
        while ($r = $rQ->fetch($rQ)) {
            if ($r ['date_start'] == $r['date_end'])
                $fl[] = 'dnia ' . substr($r['date_start'], 0, 10) . ' ' . $r['name'];
            else
                $fl[] = 'od ' . substr($r['date_start'], 0, 10) . ' do ' . substr($r['date_end'], 0, 10) . ' ' . $r['name'];
        }

        //$im = imagecreatetruecolor(540, 60);
        $im = imagecreatefrompng(CORE_DIR . '/res/default/furmBL540x60.png');
        $text_color = imagecolorallocate($im, 255, 255, 128);

        $ln = sizeof($fl);
        for ($i = 0; $i < $ln; $i++) {
            imagestring($im, 4, 24, 14 * $i, iconv('utf-8', 'ascii//translit//ignore', $fl[$i]), $text_color);
        }
        header('Content-Type: image/png');
        imagepng($im, null /* $name = cache::_pname('furmBL540x60/meetimg.png') */, 9);
        //readfile($name);
        imagedestroy($im);
    }

    public function calendarAction()
    {
        header('Content-Type: text/plain');
        $y = (int) $this->_getParam(0);
        $m = (int) $this->_getParam(1);

        $y = $y? : date('Y');
        $m = $m? : date('m');

        $s = mktime(0, 0, 0, $m, 1, $y);
        $e = mktime(0, 0, 0, $m + 1, 0, $y);

        $meets = [
            'meets' => [],
            'year' => $y,
            'month' => $m,
            'gen' => date('Y-m-d H:i:s'),
        ];

        try {
            foreach (meets\model\meet::mapper()->fetch(array(
                'date_start__lte' => date('Y-m-d', $e),
                'date_end__gte' => date('Y-m-d', $s)
            )) as $meet) {

                $item = [
                    'id' => $meet->id,
                    'url' => $meet->getUrl(),
                    'date_start' => $meet->date_start,
                    'date_end' => $meet->date_end,
                    'name' => $meet->name,
                ];
                $meets['meets'][] = $item;
            }
        } catch (\yiff\stdlib\NoFound $e) {
            $meets['no_meets'] = true;
        }

        echo json_encode($meets);
    }

}
