<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */
namespace yiff\helpers;
use yiff_session_namespace as YSN;

class msg {
    const E_WRONG = 1;
    const E_SUCCESS = 2;
    const E_NOTICE = 3;
    const notice = self::E_NOTICE;
    const success = self::E_SUCCESS;
    const error = self::E_WRONG;
    const T_FLASH = true;
    protected $_msg = array();
    public $session;
    public function __construct() {
        $this->session = new YSN('yiff_msg');
        if ($this->session->flash) {
            $this->_msg = array($this->session->{"1"},$this->session->{"2"},$this->session->{"3"});
        }
    }

    public function display() {
        
    }

    public function show() {
    $out='';
        foreach($this->_msg as $k=>$v)
        {

        if ($v) {
            switch($k):
              case self::notice : $tpl="<div style='background:#c4ff94;border-left: 8px solid rgb(75, 162, 5); padding: 2px 2px 2px 8px; color: black; font-weight: bold;'>%s</div>"; break ;
              case self::error : $tpl="<div style='background:#fd6; border-left: 8px solid orangered; padding: 2px 2px 2px 8px; color: black; font-weight: bold;'>%s</div>" ; break ;
              case self::success :
              default : $tpl="<div style='background:#c4ff94;border-left: 8px solid rgb(75, 162, 5); padding: 2px 2px 2px 8px; color: black; font-weight: bold;'>%s</div>" ;
            endswitch ;
            $tmp='';
            foreach($v as $r)
              {
              $tmp.=$r."<br>";
              }
            $out.=sprintf($tpl , $tmp) ;
        }
        }
        $this->session->reset();
        return $out;
    }
    
    public function add($msg, $type = self::E_SUCCESS, $flash = false) {
        $this->_msg[$type][] = $msg;
        if ($flash) {
            $t = $this->session->{$type};
            $t[] = $msg;
            $this->session->{$type} = $t;
            $this->session->flash = true;
        }
    }
}
