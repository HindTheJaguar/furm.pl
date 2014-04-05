<?php
namespace furm\hyper;
class calendar {

	public $de = array('Poniedziałek', 'Wrorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota', 'Niedziela');

	function newCal($y = 0, $m = 0, $d = 0) {
		if (! $y)
			$y = date('Y');
		if (! $m)
			$m = date('n');
		if (! $d)
			$d = date('d');

		$totalDays = date('t', mktime(0, 0, 0, $m, $d, $y));
		// 0- niedziela 6 - sobota
		$startDay = date('w', mktime(0, 0, 0, $m, 1, $y)) - 1;
		if ($startDay < 0)
			$startDay = 6;
		$endDay = date('w', mktime(0, 0, 0, $m, $totalDays, $y));

		$de = $this->de;

		$out = "<table class='calendar'><tr class='ui-widget-header'>";
		for($i = 0; $i < 7; $i ++) {
			$out .= "<th>" . $de [$i] . "</th>";
		}
		$ended = false;
		$i = 0;
		$in = false;
		do {
			$out .= "<tr>";
			$cm = ($m == date('n'));
			for($j = 0; $j < 7; $j ++, $i ++) {
				if ($i == $startDay)
					$in = 1;
				if ($in)
					$id = "id=day-" . $y . "-" . $m . "-" . $in . " ";
				else
					$id = '';
				if ($j == 6)
					$out .= "<td $id class='day-n'>";
				elseif ($j == 5)
					$out .= "<td $id class='day-s'>";
				else
					$out .= "<td $id class='day-a'>";

				if ($in) {
					if ($cm and $in == $d)
						$out .= "<b>" . $in . "</b>";
					else
						$out .= $in;
					$out .= '<div style="font-size:10px;">' . $this->_insertEv($in) . '</div>';
					$in ++;
				}
				else {
					$out .= "&nbsp;";
				}

				if ($in > $totalDays) {
					$in = 0;
					$ended = true;
				}
				$out .= "</td>";
			}
			$out .= "</tr>";
		} while (! $ended);
		$out .= "</table>";
		return $out;
	}

	function create($y = 0, $m = 0, $d = 0, $list = array()) {
		return $this->newCal($y, $m, $d);
	}

	function _insertEv($day) {

		$ret = '';

		if (isset($this->_ev [(int) $day]))
			foreach ($this->_ev [(int) $day] as $one) {
				$ret .= "<br>" . $one;
			}
		return $ret;
	}

	public function add($day, $ev) {
		$this->_ev [$day] [] = $ev;
	}

	function event_list($y, $ev, $link) {
		//month(c.date),n.name,
		//  From names n , content c
		$y = (int) $y;
		$ret .= "<h2>" . $y . "</h2>";
		$ret .= "<a href='" . $link . "" . (-- $y) . "'>" . ($y ++) . "</a> | <a href='" . $link . "" . (++ $y) . "'>" . $y . "</a><br>";
		$lm = 0;
		foreach ($this->_ev as $r) {
			if ($r [0] != $lm) {
				$lm = $r [3];
				$ret .= "<b>$lm </b>";
				$lmi = (int) $lm;
				$ret .= constant('miech_' . $lmi) . '<br>';
			}
			$ret .= $r [1] . "<br>\n";
		}
		return $ret;
	}
}
