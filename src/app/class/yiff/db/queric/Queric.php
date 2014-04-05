<?php

/**
 * System EKL
 * 
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2013-10-03, 06:18:23
 * 
 * Opis zmian:
 * 2013-10-03:
 * -Utworzenie pliku
 */

namespace yiff\db\queric;

use Closure;

class Queric
{

    const WHERE = 'where';
    const COLUMNS = 'columns';

    protected $_parts = array(
        'where' => '',
        'from' => '',
        'columns' => '',
        'limit' => '',
        'offset' => '',
        'join' => '',
        'bind' => '',
        'group'=>null
    );
    protected $_db;

    public function __construct($db)
    {
        $this->_db = $db;
    }

    public function from($table, $cols = null)
    {
        if (is_array($table)) {
            $table = current($table) . ' AS ' . key($table);
        }
        $this->_parts['from'] = $table;
        if ($cols) {
            $this->cols($cols);
        }
        return $this;
    }

    public function cols($cols)
    {
        $c = array();
        $cols = (array) $cols;
        foreach ($cols as $k => $col) {
            if ($col instanceof Raw) {
                $col = $col->getQueryPart();
            }
            if (is_numeric($k)) {
                $c[] = $col;
            } else {
                $c[] = $col . ' as ' . $k;
            }
        }
        $this->_parts['columns'].=implode(', ', $c);
        return $this;
    }

    public function where($colon, $value = null, $cond = '=')
    {
        $this->_where($colon, $value, $cond, 'AND');
        return $this;
    }

    public function orWhere($colon, $value, $cond)
    {
        $this->_where($colon, $value, $cond, 'OR');
        return $this;
    }

    protected function _where($colon, $value, $cond, $join)
    {
        $w = '';
        if ($this->_parts['where']) {
            $w.=' ' . $join . ' ';
        }

        if ($value instanceof RawInterface) {
            $value = $value->getQueryPart();
        }

        if ($cond === '=' && is_array($value)) {
            $cond = 'in';
        }

        $w.='(';
        if (is_null($value) and is_string($colon)) {
            if ($cond === '=' || $cond === 'is') {
                $w.= $colon . ' is null';
            } else if ($cond === '<>' || $cond === 'not') {
                $w.= $colon . ' is null';
            }
        } elseif ($cond === 'in') {
            $w.=$colon . ' IN (' . implode(',', $value) . ')';
        } elseif ($colon instanceof Closure) {
            $where = clone $this;
            $where->reset(self::WHERE);
            $colon($where);
            $w.=$where->buildWherePart();
        } elseif ($cond === '<' || $cond === '>') {
            $w.= $colon . ' ' . $cond . ' "' . $value . '"';
        } elseif ($cond === 'range' || $cond === 'between') {
            $w.=$colon . ' between ' . $value[0] . ' and ' . $value[1];
        } else {
            throw new LogicException('Not implemented');
        }



        $w.=')';
        $this->_parts['where'].=$w;
    }

    public function rawWhere($where, $join = 'AND')
    {
        if ($this->_parts['where']) {
            $this->_parts['where'].= ' ' . $join . ' ';
        }

        $this->_parts['where'].='(' . $where . ')';
        return $this;
    }

    public function __toString()
    {
        return $this->buildWherePart();
    }

    public function buildSelect()
    {
        $ret = 'SELECT ';
        if ($this->_parts['columns']) {
            $ret.=$this->_parts['columns'] . ' ';
        } else {
            $ret.= '* ';
        }
        $ret.='FROM ' . $this->_parts['from'] . ' ';

        if ($this->_parts['join']) {
            $ret.= $this->_parts['join'] . ' ';
        }

        if ($this->_parts['where']) {
            $ret.='WHERE ' . $this->_parts['where'];
        }

        if ($this->_parts['group']) {
            $ret.=' GROUP ' . implode(',', (array) $this->_parts['group']);
        }

        if ($this->_parts['limit']) {
            $ret.=' LIMIT ' . $this->_parts['limit'];
            if ($this->_parts['offset']) {
                $ret.=',' . $this->_parts['offset'];
            }
        }
        return $ret;
    }

    public function select()
    {
        
    }

    public function buildDelete()
    {
        $ret = 'DELETE ';
        $ret.='FROM ' . $this->_parts['from'] . ' ';

        if ($this->_parts['where']) {
            $ret.='WHERE ' . $this->_parts['where'];
        }

        return $ret;
    }

    public function buildTruncate()
    {
        return 'truncate ' . $this->_parts['from'];
    }

    public function buildUpdate($values)
    {
        $ret = 'UPDATE ' . $this->_parts['from'] . ' SET';
        foreach ($values as $k => $v) {
            $ret.=' ' . $k . ' = ' . $v . ',';
        }
        $ret = substr($ret, 0, -1);
    }

    public function buildWherePart()
    {
        return $this->_parts['where'];
    }

    public function reset($parts)
    {
        $this->_parts[$parts] = '';
    }

    public function group($colon)
    {
        $this->_parts['group'] = (array) $colon;
        return $this;
    }

    public function having($having)
    {
        $this->_parts['having'] = $having;
    }

    public function limit($limit, $offset = null)
    {
        $this->_parts['limit'] = $limit;
        if ($offset !== null) {
            $this->offset($offset);
        }
        return $this;
    }

    public function offset($offset)
    {
        $this->_parts['offset'] = $offset;
        return $this;
    }

    public function count()
    {
        $self = clone $this;
        $self->reset(self::COLUMNS);
    }

    public function fullColonName($colon, $from = null)
    {
        $from = $from? : $this->_parts['from'];
        if ($from) {
            return $from . '.' . $colon;
        }
        return $colon;
    }

    public function raw($expr)
    {
        return new Raw($expr);
    }

    public function leftJoin($table, $on)
    {
        return $this->join($table, $on, 'LEFT');
    }

    public function join($table, $on = array(), $joinType = '')
    {
        if ($joinType) {
            $this->_parts['join'].= ' ' . $joinType;
        }
        $this->_parts['join'].= ' JOIN ' . $table;
        if ($on) {
            if ($on instanceof Closure) {
                $w = clone $this;
                $w->resetAll();
                $on($w);
            }
            $this->_parts['join'].=' ON ' . $w->buildWherePart();
        }
        return $this;
    }

    public function resetAll()
    {
        foreach ($this->_parts as $k => &$v) {
            $v = '';
        }
        return $this;
    }

    public function exists($on, $exists = true)
    {
        if (!$exists) {
            $this->_parts['where'] . ' not';
        }
        if ($on instanceof Closure) {
            $w = clone $this;
            $w->resetAll();
            $w->cols($this->raw('1'));
            $on($w);
            $this->_parts['where'].= ' exists (' . $w->buildSelect() . ')';
        } elseif ($on instanceof Queric) {
            $this->_parts['where'].= ' exists (' . $on->buildSelect() . ')';
        } else {
            $this->_parts['where'].= ' exists (' . $on . ')';
        }
        return $this;
    }

    public function bind($name, $value)
    {
        $this->_parts['bind'] = $value;
    }

    public function getBind()
    {
        return $this->_parts['bind'];
    }

    public function stdWhere($cond, $value = null, $join = 'and')
    {
        $cond = str_replace('?', $value, $cond);
        if ($this->_parts['where']) {
            $this->_parts['where'].= ' ' . $join . ' ';
        }
        $this->_parts['where'].= $cond;
        return $this;
    }

    public function getAdapter()
    {
        return $this->_db;
    }

}
