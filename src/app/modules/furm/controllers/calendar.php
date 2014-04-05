<?php
/**
 * Furm
 * 
 * @author hind <hind@hind.pl>
 * @license BSD
 */

namespace furm;
use yiff;
define('miech_1', 'Styczeń');
define('miech_2', 'Luty');
define('miech_3', 'Marzec');
define('miech_4', 'Kwiecień');
define('miech_5', 'Maj');
define('miech_6', 'Czerwiec');
define('miech_7', 'Lipiec');
define('miech_8', 'Sierpień');
define('miech_9', 'Wrzesień');
define('miech_10', 'Październik');
define('miech_11', 'Listopad');
define('miech_12', 'Grudzień');

class calendarController extends controller
{

    public function indexAction()
    {
        $y = $this->_getParam(0);
        $m = $this->_getParam(1);

        $ret = '';
        if (!$m)
            $m = (int) date('m');
        if (!$y)
            $y = (int) date('Y');
        if ($m == 12) {
            $prev = $m - 1;
            $next = 1;
            $ynext = $y + 1;
            $yprev = $y;
        } elseif ($m == 1) {
            $prev = 12;
            $next = $m + 1;
            $ynext = $y;
            $yprev = $y - 1;
        } else {
            $prev = $m - 1;
            $next = $m + 1;
            $ynext = $y;
            $yprev = $y;
        }

        $this->view->page = constant('miech_' . $m) . ' ' . $y;
        /*?>        
        <div class="ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" id="ui-datepicker-div" style="position: absolute; top: 59px; left: 273.5px; z-index: 1; display: block;">
            <div class="ui-datepicker-header ui-widget-header ui-helper-clearfix ui-corner-all">
                <a title="&lt;Poprzedni" data-event="click" data-handler="prev" class="ui-datepicker-prev ui-corner-all"><span class="ui-icon ui-icon-circle-triangle-w">&lt;Poprzedni</span></a><a title="Następny&gt;" data-event="click" data-handler="next" class="ui-datepicker-next ui-corner-all"><span class="ui-icon ui-icon-circle-triangle-e">Następny&gt;</span></a><div class="ui-datepicker-title"><span class="ui-datepicker-month">Styczeń</span>&nbsp;<span class="ui-datepicker-year">2014</span></div></div><table class="ui-datepicker-calendar"><thead><tr><th><span title="Poniedziałek">Pn</span></th><th><span title="Wtorek">Wt</span></th><th><span title="Środa">Śr</span></th><th><span title="Czwartek">Cz</span></th><th><span title="Piątek">Pt</span></th><th class="ui-datepicker-week-end"><span title="Sobota">So</span></th><th class="ui-datepicker-week-end"><span title="Niedziela">N</span></th></tr></thead><tbody><tr><td class=" ui-datepicker-other-month ui-datepicker-unselectable ui-state-disabled">&nbsp;</td><td class=" ui-datepicker-other-month ui-datepicker-unselectable ui-state-disabled">&nbsp;</td><td data-year="2014" data-month="0" data-event="click" data-handler="selectDay" class=" "><a href="#" class="ui-state-default">1</a></td><td data-year="2014" data-month="0" data-event="click" data-handler="selectDay" class=" "><a href="#" class="ui-state-default">2</a></td><td data-year="2014" data-month="0" data-event="click" data-handler="selectDay" class=" "><a href="#" class="ui-state-default">3</a></td><td data-year="2014" data-month="0" data-event="click" data-handler="selectDay" class=" ui-datepicker-week-end "><a href="#" class="ui-state-default">4</a></td><td data-year="2014" data-month="0" data-event="click" data-handler="selectDay" class=" ui-datepicker-week-end "><a href="#" class="ui-state-default">5</a></td></tr><tr><td data-year="2014" data-month="0" data-event="click" data-handler="selectDay" class=" "><a href="#" class="ui-state-default">6</a></td><td data-year="2014" data-month="0" data-event="click" data-handler="selectDay" class=" "><a href="#" class="ui-state-default">7</a></td><td data-year="2014" data-month="0" data-event="click" data-handler="selectDay" class=" "><a href="#" class="ui-state-default">8</a></td><td data-year="2014" data-month="0" data-event="click" data-handler="selectDay" class=" "><a href="#" class="ui-state-default">9</a></td><td data-year="2014" data-month="0" data-event="click" data-handler="selectDay" class=" "><a href="#" class="ui-state-default">10</a></td><td data-year="2014" data-month="0" data-event="click" data-handler="selectDay" class=" ui-datepicker-week-end "><a href="#" class="ui-state-default">11</a></td><td data-year="2014" data-month="0" data-event="click" data-handler="selectDay" class=" ui-datepicker-week-end "><a href="#" class="ui-state-default">12</a></td></tr><tr><td data-year="2014" data-month="0" data-event="click" data-handler="selectDay" class=" "><a href="#" class="ui-state-default">13</a></td><td data-year="2014" data-month="0" data-event="click" data-handler="selectDay" class=" "><a href="#" class="ui-state-default">14</a></td><td data-year="2014" data-month="0" data-event="click" data-handler="selectDay" class=" "><a href="#" class="ui-state-default">15</a></td><td data-year="2014" data-month="0" data-event="click" data-handler="selectDay" class=" "><a href="#" class="ui-state-default">16</a></td><td data-year="2014" data-month="0" data-event="click" data-handler="selectDay" class=" "><a href="#" class="ui-state-default">17</a></td><td data-year="2014" data-month="0" data-event="click" data-handler="selectDay" class=" ui-datepicker-week-end "><a href="#" class="ui-state-default">18</a></td><td data-year="2014" data-month="0" data-event="click" data-handler="selectDay" class=" ui-datepicker-week-end "><a href="#" class="ui-state-default">19</a></td></tr><tr><td data-year="2014" data-month="0" data-event="click" data-handler="selectDay" class=" "><a href="#" class="ui-state-default">20</a></td><td data-year="2014" data-month="0" data-event="click" data-handler="selectDay" class=" "><a href="#" class="ui-state-default">21</a></td><td data-year="2014" data-month="0" data-event="click" data-handler="selectDay" class=" "><a href="#" class="ui-state-default">22</a></td><td data-year="2014" data-month="0" data-event="click" data-handler="selectDay" class=" "><a href="#" class="ui-state-default">23</a></td><td data-year="2014" data-month="0" data-event="click" data-handler="selectDay" class=" "><a href="#" class="ui-state-default">24</a></td><td data-year="2014" data-month="0" data-event="click" data-handler="selectDay" class=" ui-datepicker-week-end "><a href="#" class="ui-state-default">25</a></td><td data-year="2014" data-month="0" data-event="click" data-handler="selectDay" class=" ui-datepicker-week-end "><a href="#" class="ui-state-default">26</a></td></tr><tr><td data-year="2014" data-month="0" data-event="click" data-handler="selectDay" class=" "><a href="#" class="ui-state-default">27</a></td><td data-year="2014" data-month="0" data-event="click" data-handler="selectDay" class=" "><a href="#" class="ui-state-default">28</a></td><td data-year="2014" data-month="0" data-event="click" data-handler="selectDay" class=" ui-datepicker-days-cell-over  ui-datepicker-current-day ui-datepicker-today"><a href="#" class="ui-state-default ui-state-highlight ui-state-active">29</a></td><td data-year="2014" data-month="0" data-event="click" data-handler="selectDay" class=" "><a href="#" class="ui-state-default">30</a></td><td data-year="2014" data-month="0" data-event="click" data-handler="selectDay" class=" "><a href="#" class="ui-state-default">31</a></td><td class=" ui-datepicker-week-end ui-datepicker-other-month ui-datepicker-unselectable ui-state-disabled">&nbsp;</td><td class=" ui-datepicker-week-end ui-datepicker-other-month ui-datepicker-unselectable ui-state-disabled">&nbsp;</td></tr></tbody></table></div>
        <?php*/
        
        $stm='
            
        
<ul class="btn-group">'
                . '<li class="btn btn-default"><a title="&lt;Poprzedni" href="' . port('/calendar/index/:year:/:month:', array('year' => $yprev, 'month' => $prev)) . '" >'
                . '&laquo;Poprzedni</a></li>'
                . '<li class="btn btn-default" style="width:200px" ><a href="' . port('/calendar').'">'.constant('miech_' . $m).'</a></li>'
                . '<li class="btn btn-default"><a title="Następny&gt;" href="' . port('/calendar/index/:year:/:month:', array('year' => $ynext, 'month' => $next)) . '" >'
                . 'Następny&raquo;</a></li></ul>'
                        
     ;
        $ret.=$stm;
//        $ret .= "<table style='width:100%'><tr><td style='width:33%'><a href='" . port('/calendar/index/:year:/:month:', array('year' => $yprev, 'month' => $prev)) . "'>&laquo; " . constant('miech_' . $prev) . "</a> ";
//        $ret .= '</td><td style="width:33%;text-align:center">' . constant('miech_' . $m);
//        $ret .= "</td><td style=\"width:33%;text-align:right\"><a href='" . port('/calendar/index/:year:/:month:', array('year' => $ynext, 'month' => $next)) . "'>" . constant('miech_' . $next) . " &raquo;</a></td></tr></table>";

        $c = new \furm\hyper\calendar();
        $baseDate = mktime(0, 0, 0, $m, 1, $y);
        $date = date('Y-m', $baseDate);

        // $ret.= date('y-m-d h:i:s',$st);

        $db = yiff\stdlib\Service::get('db');

        $stmd = $db->query('SELECT name, id, date_start, date_end FROM meets WHERE \'' . $date . '-01 00:00:00\' between date_trunc(\'month\', date_start) and date_trunc(\'month\', date_end)');
//		$rQ = $this->sql->query("SELECT * FROM furms WHERE date_start < " . $se . " and date_end > " . (int) $st . " ");
        $forYM = date('Ym00', $baseDate);
        while ($r = $stmd->fetch()) {
            $ds = (int) str_replace('-', '', substr($r['date_start'], 0, 10));
            $de = (int) str_replace('-', '', substr($r['date_end'], 0, 10));
            for ($i = 0; $i < 32; $i++) {
                $n = $forYM + $i;
                if ($n >= $ds and $n <= $de) {
                    $c->add($i, '<a href="' . port('/meet/show/:id:/:name:', array('id' => $r['id'], 'name' => urlchr($r['name']))) . '">' . $r ['name'] . '</a>');
                }
            }
        }

        $ret .= $c->newCal($y, $m);
        $ret.= '<br>'.$stm;
        $this->view->content = $ret;
    }

}
