<?php

/**
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-01-18, 12:18:25
 */

namespace {

    class yiff_form_present {

        /**
         * @var EklForm
         */
        public $form;

        /**
         *
         * @var array
         */
        public $_err = array();
        public $extra = array();
        public $valid = true;
        public $_label_save = 'Zapisz';

        /**
         * Dostępne opcje do setupa:
         * form - form instance
         * errors - array z błedami k->v 
         * extra - dodatkowe pola [name, value, error]
         * valid - bool
         * populate - unused/deprecated?
         * request - pobiera 2 wartości z POSTa
         * @param array $opt 
         */
        public function __construct(array $opt = array()) {
            $this->setup($opt);
        }

        public function setup($opt) {
            if (isset($opt)) {
                $this->form = $opt['form'];
                $this->_err = $this->form->getErrors();
            }

            if (isset($opt['errors'])) {
                $this->_err = $this->_err + $opt['errors'];
            }


            if (isset($opt['extra'])) {
                foreach ($opt['extra'] as $k => $v) {
                    $this->extra['_extra_' . $k] = array($v['name'], $v['value']);
                    if (isset($v['error']) && $v['error']) {
                        $this->extra['_extra_' . $k] = $v['error'];
                    }
                }
            }

            if (isset($opt['valid'])) {
                $this->valid = $opt['valid'];
            }

            if (isset($opt['populate'])) {
                $this->form->populate($opt['populate']);
                $this->_correct = isset($opt['populate']['_correct']);
                $this->_nextstep = isset($opt['populate']['_nextstep']);
            }

            if (isset($opt['request'])) {
                $this->_correct = isset($opt['request']['_correct']);
                $this->_nextstep = isset($opt['request']['_nextstep']);
            }

            if (isset($opt['label'])) {
                if (isset($opt['label']['save'])) {
                    $this->_label_save = $opt['label']['save'];
                }
            }
        }

        public function render() {

            if (count($this->_err)) {
                $hasErr = true;
            } else {
                $hasErr = false;
            }


            echo '<form method=post>';
            echo $this->form->createHidden();
            echo '<table border=1 style="width:100%">
            <tr>
                <th style="width:30px;">Lp.</th>
                <th>Parametr</th>
                <th>Wartość</th>
                ' . (($hasErr) ? '<th>Błędy</th>' : '') . '
            </tr>
            ';
            $lp = 0;
            foreach ($this->form->present() + $this->extra as $k => $v) {
                echo '<tr>';

                echo '<td>' . (++$lp) . '</td>';
                echo '<td>' . $v[0] . '</td>';
                echo '<td>' . $v[1] . '</td>';
                if ($hasErr) {
                    echo '<td>' . $this->_err[$k] . '</td>';
                }
                echo '</tr>';
            }

            echo '<tr><td colspan=' . (($hasErr) ? 4 : 3) . ' style="text-align:center;background:#ddf;">
        ' . (($this->valid) ? '<input type=submit value="' . $this->_label_save . '" name=_nextstep>' : '') . '
        <input type=submit value="Popraw" name=_correct></tr>';
            echo '</table>';
        }

        /**
         * @return bool
         */
        public function isPresented() {
            return $this->_nextstep;
        }

        /**
         * @return bool
         */
        public function isCorrect() {
            return $this->_correct;
        }

        /**
         *
         * @return bool
         */
        public function isPresent() {
            return !($this->isPresented() || $this->isCorrect());
        }

        /**
         * @return array
         */
        public function getValues() {
            return $this->form->getValues();
        }

        public function ifCorrect() {
            if ($this->isCorrect()) {
                echo $this->form;
                return true;
            }
            return false;
        }

        public function ifPresent() {
            if ($this->isPresent()) {
                $this->render();
                return true;
            }
            return false;
        }

    }

}

namespace yiff\form {

    class present extends \yiff_form_present {
        
    }

}