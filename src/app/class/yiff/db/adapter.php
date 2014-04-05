<?php

/**
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2011-08-01
 */

namespace yiff\db;

use yiff\cache\cache;
use PDO;

class adapter
{

    protected $_conf;

    /**
     *
     * @var PDO
     */
    protected $_conn;
    protected $_queryCnt = 0;
    static protected $map = array();
    public $profiler = null;

    public function __construct($conf)
    {
        $this->_conf = $conf;
        $this->connect();
    }

    public function connect()
    {
        $this->_conn = new PDO(sprintf('pgsql:host=%s;dbname=%s', $this->_conf['host'], $this->_conf['name']), $this->_conf['user'], $this->_conf['pass']);
        $this->_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//pg_connect("host=" . $this->_conf['host'] . " dbname=" . $this->_conf['name'] . " user=" . $this->_conf['user'] . " password=" . $this->_conf['pass'] . "");
    }

    public function close()
    {
        unset($this->_conn);
//        pg_close($this->_conn);
    }

    public function getQueryCount()
    {
        return $this->_queryCnt;
    }

    public function query($sql, array $bind = null)
    {
        $this->_queryCnt++;
        if ($this->profiler) {
            $start = microtime(true);
        }

        if ($bind) {
            $bind = $this->_prepareBind($bind);
            $res = $this->_conn->prepare($sql);
            $res->execute($bind);
        } else {
            $res = $this->_conn->query($sql);
        }
        if (!$res) {
            throw new exception;
//            $e = new exception(pg_errormessage($this->_conn));
//            $e->sql = $sql;
//            throw $e;
        }
        if ($this->profiler) {
            $this->profiler->add($sql, $start, microtime(true), $res->rowCount());
        }
        return new stmt($res, $sql);
    }

    public function insert($table, $data)
    {
        $values = array();
        foreach ($data as $k => $v) {
            $v = $this->escapeValue($table, $k, $v);
            $values[] = $v;
        }
        $ret = $this->query($q = "INSERT INTO " . $table . " (\"" . implode('","', array_keys($data)) . "\") VALUES (" . implode(',', $values) . ")");
        return $ret;
    }

    public function escapeValue($table, $column, $value)
    {
        if (!isset(self::$map[$table])) {
            self::$map[$table] = $this->describe_table($table);
        }

        $a = & self::$map[$table][$column];

        switch ($a['data_type']) {
            case 'boolean':
                if ($value) {
                    $value = 'TRUE';
                } else {
                    $value = 'FALSE';
                }
                break;
            case 'integer':
                if (is_object($value)) {
                    $value = $value->value;
                }
                $value = (int) $value;
                break;
            case 'character varying':
                if (strlen($value) > $a['character_maximum_length']) {
                    throw new exception('text too big');
                }
                $value = $this->escapeString($value);
                break;
            case 'timestamp with time zone':
                if ($value instanceof \yiff\stdlib\DateTime) {
                    $value = $this->escapeString($value->getDBvalueTZ());
                }
                break;
            case 'timestamp without time zone':
                if ($value instanceof \yiff\stdlib\DateTime) {
                    $value = $this->escapeString($value->getDBvalue());
                }
                break;
            default:
                $value = $this->escapeString($value);
        }



//            if ($value === '')
//                if($a['is_nullable'] == 'YES') {
//                    $value = 'NULL';
//                } else {
//                    throw new \yiff\db\exception($table.' c '.$column.' cannot be null');
//                }
        return $value;
    }

    /**
     * 
     * @param type $table
     * @param type $data
     * @param type $where
     * @return \yiff\db\stmt
     */
    public function update($table, $data, $where)
    {
        if (!$data) {
            return;
        }

        $where = $this->buildWhere($where);
        //$k = array_keys($data);
        $updt = array();
        foreach ($data as $k => $v) {
            $v = $this->escapeValue($table, $k, $v);
            $updt[] = '"' . $k . '" = ' . $v;
        }
        $q = "UPDATE " . $table . " SET " . implode(',', $updt) . " WHERE " . $where;

        return $this->query($q);
    }

    public function fetchRow($sql, array $bind = null)
    {
        return $this->query($sql, $bind)->fetch();
    }

    /**
     * @deprecated
     */
    public function row($sql)
    {
        $stmt = $this->query($sql);
        return $stmt->fetch();
    }

    public function fetchValue($sql, array $bind = null)
    {
        return $this->query($sql, $bind)->fetch(PDO::FETCH_NUM)[0];
    }

    public function quote($var)
    {
        if (is_numeric($var)) {
            return $var;
        }

        if (is_array($var)) {
            return implode(',', $var);
        }

        return $this->escapeString($var);
    }

    public function fetchAll($query, array $bind = null)
    {
        return $this->query($query, $bind)->fetchAll();
    }

    public function describe_table($name)
    {
        if (isset(self::$map[$name])) {
            return self::$map[$name];
        }
        $success = null;
        $ret = cache::fetch('db.schema.' . $name, $success);
        if ($success) {
            return self::$map[$name] = $ret;
        }

        if ($pos = strpos($name, '.')) {
            $schema = substr($name, 0, $pos);
            $pos++;
            $column = substr($name, $pos);
        } else {
            $schema = 'public';
            $column = $name;
        }
        $sql = <<<EOT
select * from INFORMATION_SCHEMA.COLUMNS where table_catalog = '{$this->_conf['name']}' AND table_schema not in ('information_schema', 'pg_catalog') and table_schema = '{$schema}' AND table_name = '{$column}'
EOT;
        $ret = array();
        foreach ($this->query($sql)->fetchAll() as $v) {
            $ret[$v['column_name']] = $v;
        }

        cache::store('db.schema.' . $name, $ret, 600);
        return self::$map[$name] = $ret;
    }

    public function escapeString($str)
    {
        return $this->_conn->quote($str);
    }

    /**
     * StdQuery
     * 
     * @param \yiff\db\Queric|String $array
     * @return type
     */
    public function buildWhere($array)
    {
        if (is_string($array)) {
            return $array;
        } elseif ($array instanceof \yiff\db\queric\Queric) {
            return $array->buildWherePart();
        }
        $ret = '';
        foreach ($array as $k => $v) {
            if (is_array($v) and is_numeric($k)) {
                $ret.=' OR (' . $this->buildWhere($v) . ')';
            } else {
                if (is_object($v)) {
                    $v = $v->value;
                } else if (is_array($v)) {
                    $v = '(\'' . implode('\',\'', $v) . '\')';
                } else if (!is_numeric($v)) {
                    $v = $this->escapeString($v);
                }
                $ret.=' AND ' . str_replace('?', $v, $k);
            }
        }
        return substr($ret, 4);
    }

    public function nextval($seq)
    {
        return $this->fetchValue('SELECT nextval(\'' . $seq . '\')');
    }

    public function delete($table, $where = array(), array $bind = null)
    {

        if ($where) {
            $where = ' WHERE ' . $this->buildWhere($where);
        } else {
            $where = '';
        }
        $ret = $this->query('delete from ' . $table . $where, $bind);
        return $ret->affected();
    }

    /**
     * 
     * @return \yiff\db\queric\Queric
     */
    public function queric()
    {
        return new queric\Queric($this);
    }
    
    /**
     * Dodaje znak ':' przed każdym z bindów
     * 
     * @param array $bind
     * @return array
     */
    protected function _prepareBind($bind)
    {
        foreach($bind as $k=>$v) {
            $bind[':'.$k] = $v;
            unset($bind[$k]);
        }
        return $bind;
    }

}
