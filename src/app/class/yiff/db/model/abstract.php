<?php

class yiff_db_model_abstract implements ArrayAccess
{

    /**
     * @var \yiff\db\adapter
     */
    static public $db;
    protected $_name;
    protected $_rowClass = 'yiff_db_model_abstract_entity';
    protected $_sequence = true;
    protected $_sequence_name = '';
    protected $filters = array();
    protected $validators = array();
    protected $_readonly = false;
    protected $_boolcode = array();

    static public function setDb($db)
    {
        self::$db = $db;
    }

    /**
     * @var \yiff\db\adapter
     */
    protected $_db;
    protected $_map = array();
    protected $_primary = 'id';
    public $_described;

    public function __construct(array $conf = array())
    {
        if (isset($conf['db'])) {
            $this->_db = $conf['db'];
        } else {
            $this->_db = self::$db;
        }

        if (isset($conf['name'])) {
            $this->_name = $conf['name'];
        }

        if (isset($conf['row_class'])) {
            $this->_rowClass = $conf['row_class'];
        }

        $this->_sequence_name = $this->_name . '_id_seq';

        if (!$this->_described) {
            $this->_described = $this->_db->describe_table($this->_name);
            foreach ($this->_described as $k => $v) {
                if ($v['data_type'] == 'boolean') {
                    $this->_boolcode[$k] = $k;
                }
            }
        }

        $this->init();
    }

    public function init()
    {
        
    }

    protected function _preInsert($data)
    {
        
    }

    public function insert($data)
    {
        if ($this->_readonly) {
            throw new yiff\db\model\modelException('Readonly');
        }

        foreach ($data as $k => $v) {
            if (isset($this->validators[$k])) {
                $this->_applyValidators($k, $v);
            }
        }

        if ($this->_sequence && !isset($data[$this->_primary])) {
            $seq = $this->_db->nextval($this->_sequence_name);
            $data[$this->_primary] = $seq;
        } else {
            if (is_array($this->_primary)) {
                $seq = array();
                foreach ($this->_primary as $v) {
                    $seq[$v] = $data[$v];
                }
            } else {
                $seq = $data[$this->_primary];
            }
        }
        $this->_preInsert($data);


        $this->_db->insert($this->_name, $data);
        return $seq;
    }

    public function update($data, $primary)
    {
        if ($this->_readonly) {
            throw new yiff\db\model\modelException('Readonly');
        }

//        foreach ($data as $k => $v) {
//            if (isset($this->validators[$k])) {
//                $this->_applyValidators($k, $v);
//            }
//        }

        if ($r = $this->_db->update($this->_name, $data, $primary)) {
            return $r->affected();
        }
    }

    public function _applyFilters($k, $v)
    {
        return $v;
    }

    public function _applyAllFilters(array $data)
    {
        foreach ($data as $k => $v) {
            $data[$k] = $this->_applyFilters($k, $v);
        }
        return $data;
    }

    protected function _applyValidators($k, $v)
    {
        
    }

    public function create(array $data = array())
    {

        //$d = $this->_db->describe_table($this->_name);

        foreach ($data as $k => $v) {
            if (!isset($this->_described[$k])) {
                throw new yiff\db\model\modelException('unknown field ' . $k);
            }
        }

        $conf = array(
            'table' => $this,
            'org' => array(),
            'data' => $this->_applyAllFilters($data),
            'primary' => $this->_primary,
        );
        $cls = new $this->_rowClass($conf);
        return $cls;
    }

    public function findOne($id)
    {

        if (is_array($this->_primary)) {
            if (!is_array($id)) {
                throw new yiff\db\model\modelException('multiple primary key, one given');
            }
            $d = array();
            foreach ($this->_primary as $v) {
                $d[] = $v . ' = ' . $id[$v];
            }
            $q = 'SELECT * FROM ' . $this->_name . ' WHERE ' . implode(' AND ', $d) . ' LIMIT 1';
        } else {
            $id = (int) $id;
            $q = 'SELECT * FROM ' . $this->_name . ' WHERE "' . $this->_primary . '" = ' . $id . ' LIMIT 1';
        }

        if (!$data = $this->_db->row($q)) {
            throw new \yiff\stdlib\NoFound('Item no found');
        }

//        $this->_filtrBool($row);
        return new $this->_rowClass(array(
            'table' => $this,
            'data' => $data,
            'org' => $data,
            'primary' => $this->_primary,
        ));
    }

    public function find($ids)
    {
        $ret = array();
        foreach ($this->fetchAll(array('id IN ?' => $ids)) as $v) {
            $ret[$v->{$this->_primary}] = $v;
        }
        return $ret;
    }

    public function fetchRow($where, $order = null)
    {
        $where = $this->_db->buildWhere($where);
        if ($order) {
            $order = ' ORDER BY ' . $order;
        } else {
            $order = '';
        }
        $stmd = $this->_db->query('SELECT * FROM ' . $this->_name . ' WHERE ' . $where . $order . ' LIMIT 1');
        $row = $stmd->fetch();
        if ($row) {
//            $this->_filtrBool($row);
            return new $this->_rowClass(array(
                'data' => $row,
                'org' => $row,
                'table' => $this,
                'primary' => $this->_primary,
            ));
        }
    }

    /**
     *
     * @param mixed $where
     * @param string $limit
     * @param string $order
     * @return array
     */
    public function fetchAll($where = null, $order = null, $limit = null, array $bind = null)
    {
        if ($where) {
            $where = $this->_db->buildWhere($where);
        }

        if ($limit) {
            $limit = ' LIMIT ' . $limit;
        }

        if ($order) {
            $order = ' ORDER BY ' . $order;
        } else {
            $oredr = '';
        }

        $q = 'SELECT * FROM ' . $this->_name . ' ' . (($where) ? 'WHERE ' . $where : '') . $order . $limit;
        
        $ret = $this->_db->fetchAll($q);
        return new yiff\db\model\rowsetAbstract([
            'data' => $ret,
            'table' => $this,
            'primary' => $this->_primary,
            'row_class' => $this->_rowClass
        ]);
    }
    

    public function delete($where)
    {
        if (is_array($where)) {
            $where = $this->_db->buildWhere($where);
        }
        return $this->_db->query('DELETE FROM ' . $this->_name . ' WHERE ' . $where)->affected();
    }

    public $dependency = array();

    /**
     * 
     * @return type
     * @deprecated
     */
    public function getInjections()
    {
        return $this->dependency;
    }

    /**
     * @deprecated
     * @param type $name
     * @param type $class
     */
    public function factoryInject($name, $class)
    {
        $this->{$name} = $class;
    }

    /**
     * 
     * @return yiff\db\queric\Queric
     */
    public function select()
    {
        $select = $this->_db->queric();
        $select->from(array('basetable' => $this->_name));
        return $select;
    }
    
    public function offsetExists($offset)
    {
        ;
    }
    
    public function offsetGet($offset)
    {
        return $this->findOne($offset);
    }
    
    public function offsetSet($offset, $value)
    {

    }
    
    public function offsetUnset($offset)
    {
        ;
    }

}
