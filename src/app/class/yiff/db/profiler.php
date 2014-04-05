<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */
namespace yiff\db;

class profiler {
    const ALL = 0;
    protected $_data = array();
    public function add($sql, $start, $stop, $result = null) {
        $this->_data[] = array(
            'sql'=>$sql,
            'start'=>$start,
            'stop'=>$stop,
            'time'=>($stop - $start),
            'result'=>$result,
        );
    }

    public function read($t = self::ALL) {
        if ($t == self::ALL) {
            return $this->_data;
        } else {
            $r = array();
            foreach($this->_data as $v) {
                $r[] = $v['sql'];
            }
            return $r;
        }
    }


}