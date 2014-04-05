<?php

/**
 * Abstract dla elementów forma
 * 
 * @author Przemysław 'Hind' Jakubowski
 */
abstract class yiff_form_element_abstract implements ArrayAccess {

    /**
     * Czy dany element ma być wyświetlany
     * @var bool
     */
    public $display = true;

    /**
     * Lista dekoratorów
     * @var array
     */
    public $decorators = array('label');

    /**
     * Podstawowe parametry
     * @var string
     */
            public $label, $name, $value, $_ignore, $error, $require, $error_msg;

    /**
     * Parametry wewnętrzne elementu
     * @var array
     */
    public $_attr = array();

    /**
     * Opcje dodatkowe dla elementu DOM
     * @var array
     */
    public $_form_attr = array();

    public function __construct($name, array $opt = array()) {
        $this->name = $name;
        $this->_form_attr['value'] = &$this->value;
        $this->setup($opt);
    }

    public function setup($opt) {

        if (isset($opt['label'])) {
            $this->setLabel($opt['label']);
        }

        if (isset($opt['ignore']) && $opt['ignore']) {
            $this->setIgnore();
        }

        if (isset($opt['value'])) {
            $this->setValue($opt['value']);
        }

        if (isset($opt['decorators'])) {
            $this->decorators = $opt['decorators'];
        }

        if (isset($opt['attr'])) {
            foreach ($opt['attr'] as $k => $v) {
                $this[$k] = $v;
            }
        }

        if (isset($opt['display'])) {
            $this->display = $opt['display'];
        }

        if (isset($opt['error']) && $opt['error']) {
            $this->error = true;
            $this->error_msg = $opt['error'];
        }

        if (isset($opt['require'])) {
            $this->require = $opt['require'];
        }
    }

    /**
     * dekoruje element
     * 
     * @param string $in
     * @return string
     */
    public function _decorate($in, $decorators) {
        foreach ($decorators as $v) {
            if (method_exists($this, 'decorator_' . $v)) {
                $in = $this->{'decorator_' . $v}($in);
            } elseif (yiff\stdlib\Service::get('yiff_form_decorator_' . $v)) {
                $in = yiff\stdlib\Service::get('yiff_form_decorator_' . $v)->decorate($in, $this);
            }
        }
        return $in;
    }

    public function decorate(array $decorators = null) {
        return $this->_decorate($this->create(), $decorators ? $decorators : $this->decorators);
    }

    /**
     * Dekorator label
     *
     * @param string $in
     * @return string
     */
    public function decorator_label($in) {
        return "<div id='field-" . $this->name . "' class='form-field'>
    <div id='label-" . $this->name . "' class='form-label'>" . $this->label . "</div>
    <div id='content-" . $this->name . "' class='form-content'>" . $in . "</div>
    </div>";
    }

    public function decorator_tblpart($in) {
        return "
    <tr>
        <td>{$this->label}" . (($this->require) ? '<span style="color:red">*</a>' : '') . "</td>
        <td>{$in}</td>
    </tr>
";
    }

    public function decorator_error($in) {
        if (!$this->error) {
            return $in;
        }

        return $in . '<div style="color:red">' . $this->error_msg . '</div>';
    }

    /**
     * Ustawia label
     *
     * @param string $label
     * @return form_element_abstract
     */
    public function setLabel($label) {
        $this->label = $label;
        return $this;
    }

    /**
     * Ustawia wartość elementu
     *
     * @param string $value
     * @return form_element_abstract
     */
    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    /**
     * Pobiera wartość elementu
     *
     * @return string
     */
    public function getValue() {
        return $this->value;
    }

    public function value() {
        return $this->value;
    }

    /**
     * Ustawia atrybut element
     * 
     * @param string $name
     * @param string $value
     * @return form_element_abstract u
     */
    public function setAttr($name, $value) {
        $this->_form_attr[$name] = $value;
        return $this;
    }

    public function unsetAttr($name) {
        unset($this->_form_attr[$name]);
        return $this;
    }

    /**
     * Zwraca wartość atrybutu elementu
     * 
     * @param <type> $name
     * @return string
     */
    public function getAttr($name) {
        return $this->_form_attr[$name] = $value;
    }

    /**
     * ustawia opcje elementu
     *
     * @param string $k klucz
     * @param string $v wartość
     * @return form_element_abstract
     */
    public function setOpt($k, $v) {
        $this->_attr[$k] = $v;
        return $this;
    }

    /**
     * Pobiera opcje elementu
     * 
     * @param string $key
     * @return string 
     */
    public function getOpt($key) {
        if (isset($this->_attr[$key]))
            return $this->_attr[$key];
    }

    public function __set($key, $value) {
        $this->_attr[$key] = $value;
    }

    public function __get($key) {
        if (isset($this->_attr[$key]))
            return $this->_attr[$key];
    }

    public abstract function create();

    public function __toString() {
        return $this->create();
    }

    /**
     * ustawia czy ma pomijać przy form::getValues()
     *
     * @param bool $ignore
     * @return form_element_abstract
     */
    public function setIgnore($ignore = true) {
        $this->_ignore = $ignore;
        return $this;
    }

    /**
     * Sprawdza czy element jest ignorowany
     *
     * @return bool
     */
    public function isIgnored() {
        return $this->_ignore;
    }

    protected function _htmlAttr() {
        $ret = '';
        foreach ($this->_form_attr as $k => $v) {
            if ($k == 'value') {
                continue;
            }
            $ret.= ' ' . $k . '="' . $v . '"';
        }
        return $ret;
    }

    public function offsetExists($offset) {
        return isset($this->_form_attr[$offset]);
    }

    public function offsetGet($offset) {
        return $this->_form_attr[$offset];
    }

    public function offsetSet($offset, $value) {
        $this->_form_attr[$offset] = $value;
    }

    public function offsetUnset($offset) {
        unset($this->_form_attr[$offset]);
    }

}
