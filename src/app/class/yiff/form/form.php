<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2013-05-07, 21:01:31
 */


namespace yiff\form;

class form implements \ArrayAccess , \yiff\stdlib\toArray {

    /**
     *
     * @var from_present
     */
    protected $_presenter;
    public $params = array(
        'method' => 'post',
        'action' => '',
        'enctype' => 'application/x-www-form-urlencoded',
    );
    protected $_decorators = array();

    const IGNORED = false;
    const NO_IGNORED = true;
    const DISPLAY = true;
    const NO_DISPLAY = false;
    const POST = "POST";
    const GET = "GET";

    public $_forms = array();
    public $_values = array();
    public $_valider;
    public $_view;
    public $_errors = array();
    protected $_attr = array();

    /**
     *
     * @param string|yiff\form\element\abstract $element
     * @param string $name
     * @param array $params
     * @return form 
     */
    public function addElement($element, $name = null, $params = array()) {
        if (is_string($element)) {
            $element = 'yiff\\form\\element\\' . $element;
//            $params['name']=$name;
            $element = new $element($name, $params);
            $this->_forms[$name] = $element;
        } else {
            $this->_forms[$element->name] = $element;
        }
        return $this;
    }

    /**
     *
     * @param array $d
     * @return form 
     */
    public function selfDecorate(array $d = null) {
        $this->_decorators = $d;
        return $this;
    }

    public function __construct($args = null) {
        $this->_args = $args;
        $this->init();
    }

    /**
     * Metoda dla klas dziedziczących aby nie nadpisywały konstruktora
     */
    public function init() {
        
    }

    /**
     * Sprawdza czy dane w formularzu są poprawne
     * @param valider $valid
     */
    public function isValid(interface_valider $valid) {
        $this->_valier = $valid;
        return $valid->isValidAll($this->getValues());
    }

    public function getErrors() {
        if ($this->_valider instanceof interface_valider) {
            return $this->_valider->getErrors();
        } else {
            return $this->_errors;
        }
    }

    /**
     * Ustawia adres forma
     * @param string $action
     * @return form
     */
    public function setAction($action) {
        $this->params['action'] = $action;
        return $this;
    }

    /**
     * Ustawia motodę wysyłania danych
     * @param string $method
     * @return form
     */
    public function setMethod($method) {
        $this->params['method'] = $method;
        return $this;
    }

    /**
     * Pobiera element formularza
     * @param string $name
     * @return form_element_abstract
     */
    public function getElement($name) {
        if (isset($this->_forms[$name])) {
            return $this->_forms[$name];
        } else {
            return null;
        }
    }

    /**
     * Dodaje nowy element formularza
     * @param yiff\form\element\abstract $el
     * @return form
     */
    public function setElement($el, $name = '', $opt = array()) {
        if ($el instanceof \yiff\form\element\elementAbstract) {
            $this->_forms[$el->name] = $el;
            return $this;
        } else {
            $el = "yiff\\form\\element\\" . $el;
            $el = new $el($name, $opt);
            $this->_forms[$name] = $el;
        }


        return $this;
    }

    /**
     * Pobiera wartości elementów
     * @return array
     */
    public function getValues($all = self::NO_IGNORED) {
        $return = array();
        foreach ($this->_forms as $name => $element) {
            if ($all === self::NO_IGNORED && $element->isIgnored())
                continue;
            $return[$name] = $element->getValue();
        }
        return $return;
    }

    /**
     * Ustawia typ transferu
     *
     * @param bool $set
     * @return form
     */
    public function setMultipart($set = true) {
        if ($set) {
            $this->params['enctype'] = "multipart/form-data";
        } else {
            $this->params['enctype'] = "application/x-www-form-urlencoded";
        }
        return $this;
    }

    /**
     * Tworzy formularz
     * @return string
     */
    public function create() {
        if ($this->_view) {
            $this->_view->form = $this;
            return $this->_view;
        }

        $return = $this->getFormTag();
        foreach ($this->_forms as $v) {
            if ($v->display) {
                $return.=$v->decorate();
            }
        }
        $return.='</form>';

        if (is_array($this->_decorators)) {
            foreach ($this->_decorators as $decorator) {
                $return = $this->_decorate($return, $decorator);
            }
        }
        return $return;
    }

    public function _decorate($in, $v) {

        if (method_exists($this, 'decorator_' . $v)) {
            $in = $this->{'decorator_' . $v}($in);
//      } elseif (get('form_decoratorForm_' . $v)) {
//        $in = get('form_decoratorForm_' . $v)->decorate($in, $this);
        }

        return $in;
    }

//  public function decorator_from($i) {
//      return $i;
//  }

    public function decorator_table($in) {
        return '<table style="width:100%" border="1">
          <colgroup>
            <col style="width:30%" />
            <col style="width:70%" />
          </colgroup>
          ' . $in . '
    </table>';
    }

    public function getFormTag($params = false) {
        $attr = array();
        foreach ($this->_attr as $k => $v) {
            $attr[] = $k . '="' . $v . '"';
        }
        $attr = implode(' ', $attr);
        if ($params) {
            return 'method="' . $this->params['method'] . '" ' . $attr . ' action="' . $this->params['action'] . '"' . (($this->params['enctype']) ? ' enctype="' . $this->params['enctype'] . '"' : '');
        } else {
            return '<form method="' . $this->params['method'] . '" ' . $attr . ' action="' . $this->params['action'] . '"' . (($this->params['enctype']) ? ' enctype="' . $this->params['enctype'] . '"' : '') . '>';
        }
    }

    public function getFormTagEnd() {
        return '</form>';
    }

    /**
     * Przypisuje domyślne dane do formularza
     * @param array $values
     * @return form
     */
    public function populate($values) {
        if ($values instanceof \yiff_router_request) {
            $values = $values->getAllParams();
        } elseif ($values instanceof \yiff\stdlib\toArray) {
            $values = $values->toArray();
        } elseif (!is_array($values)) {
            throw new exception('Wrong param');
        }
        foreach ($values as $k => $v) {
            if (isset($this->_forms[$k])) {
                $this->_forms[$k]->setValue($v);
            }
        }
        return $this;
    }

    /**
     * Czyści dane w formularzu
     * @return form
     */
    public function reset() {
        foreach ($this->_forms as $element) {
            $element->setValue('');
        }
        return $this;
    }

    /**
     * overload zwracający form::create()
     * @return string
     */
    public function __toString() {
        return $this->create();
    }

    /**
     * Overload form::getElement()
     * @param yiff\form\element\abstract $name
     */
    public function __get($name) {
        return $this->getElement($name);
    }

    public function setView($view) {
        $this->_view = $view;
        return $this;
    }

    public function __sleep() {
        $this->_values = $this->getValues(self::IGNORED);
        return array('_values');
    }

    public function __wakeup() {
        $this->init();
        $this->populate($this->_values);
    }

    public function createHidden() {
        $ret = '';
        foreach ($this->getValues() as $k => $v) {
            $ret.='<input type="hidden" name="' . $k . '" value="' . str_replace('"', '&quot;', $v) . '">';
        }
        return $ret;
    }

    public function present(EklValid $valider = null) {
        $return = array();
        if ($valider === null && $this->_valider) {
            $valider = $this->_valider;
        }

        foreach ($this->_forms as $name => $element) {
            if ($element->isIgnored())
                continue;
            $return[$name] = array($element->label, $this->getPresent($name), $valider ? $valider->getError($name) : '');
        }
        return $return;
    }

    public function getPresent($key) {
        if (method_exists($this, '_' . $key . 'Present')) {
            return $this->{'_' . $key . 'Present'}();
        } else {
            return $this->getValue($key);
        }
    }

    /**
     *
     * @param array $opt
     * @return yiff_form_present
     */
    public function getPresenter(array $opt = array()) {
        if (!$this->_presenter || $opt) {
            $this->_presenter = new \yiff_form_present($opt + array(
                        'form' => $this,
                        'errors' => $this->getErrors(),
                        'valid' => !count($this->getErrors()),
                    ));
        }
        return $this->_presenter;
    }

    public function getValue($key) {
        if (isset($this->_forms[$key])) {
            return $this->_forms[$key]->value();
        }
    }

    /**
     * @return array
     */
    public function toArray() {
        return $this->getValues();
    }

    /**
     * @param array $decorators
     * @return form
     */
    public function decorators(array $decorators) {
        foreach ($this->_forms as $v) {
            $v->decorators = $decorators;
        }
        return $this;
    }

    /**
     * Ustawia atrybut element
     *
     * @param string $name
     * @param string $value
     * @return form_element_abstract u
     */
    public function setAttr($name, $value) {
        $this->_attr[$name] = $value;
        return $this;
    }

    public function unsetAttr($name) {
        unset($this->_attr[$name]);
        return $this;
    }

    /**
     * Zwraca wartość atrybutu elementu
     *
     * @param string $name
     * @return string
     */
    public function getAttr($name) {
        return $this->_attr[$name] = $value;
    }

    /**
     * ArrayAcces interface
     * @param string $offset
     * @return bool
     */
    public function offsetExists($offset) {
        return isset($this->_attr[$offset]);
    }

    /**
     * ArrayAcces interface
     * @param string $offset
     * @return string 
     */
    public function offsetGet($offset) {
        return $this->getAttr($offset);
    }

    /**
     * ArrayAcces interface
     * @param string $offset
     * @param string $value
     * @return string
     */
    public function offsetSet($offset, $value) {
        return $this->setAttr($offset, $value);
    }

    /**
     * ArrayAcces interface
     * @param string $offset
     * @return bool
     */
    public function offsetUnset($offset) {
        return $this->unsetAttr($offset);
    }

    public function setErrors(array $errors) {
        $this->_errors = $errors;
        foreach ($errors as $k => $v) {
            $this->$k->error = true;
            $this->$k->error_msg = $v;
        }
    }

}
