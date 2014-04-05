<?php

class yiff_db_model_abstract_entity implements ArrayAccess, yiff\stdlib\toArray
{

    protected $_data;
    protected $_org;

    /**
     * @var yiff_db_model_abstract
     */
    protected $_model;
    protected $_primary;

    public function __construct(array $data = null)
    {
        if ($data === null) {
            $this->init();
        }
        $this->_primary = $data['primary'];
        if (!is_array($this->_primary)) {
            $this->_primary = array($this->_primary);
        }
        $this->_data = $data['data'];
        $this->_org = $data['org'];
        $this->_model = $data['table'];
        $this->init();
    }

    public function init()
    {
        
    }

    public function update($data)
    {
        if (!(is_array($data) || $data instanceof Traversable)) {
            if ($data instanceof yiff\stdlib\toArray) {
                $data = $data->toArray();
            } else {
                throw new DomainException('Zły typ danych');
            }
        }
        foreach ($data as $k => $v) {
            $this->__set($k, $v);
        }
        return $this;
    }

    public function _doInsert()
    {
        $primary = $this->_model->insert($this->_data);
        if ($primary && $this->_primary) {
            if (!isset($this->_primary[1])) {
                $this->_data[$this->_primary[0]] = $primary;
            } else {
                $primary = array();
                foreach ($this->_primary as $v) {
                    $primary[$v] = $this->_data[$v];
                }
            }
        }
        $this->_org = $this->_data;
        return $primary;
    }

    public function _doUpdate()
    {
        $delta = array();
        foreach ($this->_org as $k => $v) {
            if ($this->_data[$k] !== $v) {
                $delta[$k] = $this->_data[$k];
            }
        }

        if (empty($delta)) {
            return;
        }

        $this->_preUpdate($delta);

        if (isset($this->_primary[1])) {
            $d = array();
            foreach ($this->_primary as $v) {
                $d[] = $v . ' = ' . $this->_org[$v];
            }
            $d = implode(' AND ', $d);
            $r = $this->_model->update($delta, $d);
        } else {
            $r = $this->_model->update($delta, $this->_primary[0] . ' = ' . $this->_org[$this->_primary[0]]);
        }
        $this->_org = $this->_data;
        return $r;
    }

    protected function _preUpdate($delta)
    {
        
    }

    public function save()
    {
        if ($this->_org) {
            return $this->_doUpdate();
        } else {
            return $this->_doInsert();
        }
    }

    public function __get($name)
    {
        $fname = '__get' . $name;
        if (method_exists($this, $fname)) {
            return $this->$fname();
        }

        if (isset($this->_data[$name])) {
            return $this->_data[$name];
        }
    }

    public function __set($name, $value)
    {

        $value = $this->_model->_applyFilters($name, $value);
        $fname = '__set' . $name;
        if (method_exists($this, $fname)) {
            $value = $this->$fname($value);
            if (!isset($this->_model->_described[$name])) {
                return;
            }
        }

        if (isset($this->_model->_described[$name])) {
            $this->_data[$name] = $value;
        } else {
            throw new yiff\db\model\modelException('unkonow field ' . $name);
        }
    }

    public function __isset($name)
    {
        return isset($this->_data[$name]);
    }

    public function __unset($name)
    {
        $this->_data[$name] = NULL;
    }

    public function toArray()
    {
        return $this->_data;
    }

    public function delete()
    {
        if (isset($this->_primary[1])) {
            $d = array();
            foreach ($this->_primary as $v) {
                $d[] = $v . ' = ' . $this->_org[$v];
            }
            $d = implode(' AND ', $d);
            $this->_model->delete($delta, $d);
        } else {
            $this->_model->delete($this->_primary[0] . ' = ' . $this->_org[$this->_primary[0]]);
        }
    }

    public function date($field, $format = null)
    {
        return substr($this->{$field}, 0, 19);
    }

    /**
     * @return yiff_db_model_abstract
     */
    public function getTable()
    {
        return $this->_model;
    }

    public function offsetExists($offset)
    {
        return $this->__isset($offset);
    }

    public function offsetGet($offset)
    {
        return $this->__get($offset);
    }

    public function offsetSet($offset, $value)
    {
        return $this->__set($offset, $value);
    }

    public function offsetUnset($offset)
    {
        return $this->__unset($offset);
    }

    /**
     * 
     * @return yiff_db_model_abstract
     */
    public static function model()
    {
        $tbl = \yiff\db\model\factory::factory(get_called_class());
        if (!\yiff\stdlib\Registry::check('model_' . $tbl['table'])) {
            \yiff\stdlib\Registry::set('model_' . $tbl['table'], new $tbl['model'](array(
                'name' => $tbl['table'],
                'row_class' => get_called_class(),
            )));
        }
        return \yiff\stdlib\Registry::get('model_' . $tbl['table']);
    }

    public function getDate($value)
    {
        return new \yiff\stdlib\DateTime(substr($this->$value, 0, 19));
    }

}
