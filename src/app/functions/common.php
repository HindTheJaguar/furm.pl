<?php

function __($lng) {
    return $lng;
}

function urlchr($i) {
  $i = iconv('UTF-8', 'ASCII//TRANSLIT',$i);
  return preg_replace('/[^a-zA-Z0-9]/U','-',$i);
  }

function gravatar($mail, $size=100) {
  return "https://secure.gravatar.com/avatar.php?gravatar_id=".md5( strtolower($mail) ).
//"&default=".urlencode($this->default).
"&size=".$size;
}
  
function port($portName = null, $portArgs = null) {
    if ($portName === null) {
        return 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    }

    $args = '';

    if ($portArgs) {
        $args = '/?';
        foreach($portArgs as $k=>$v) {
            $oldName = $portName;
            $portName = str_replace(':'.$k.':', $v, $portName);
            if ($oldName === $portName) {
                $args.=$k.'='.$v.'&';
            }
        }
        $args = substr($args,0,-1);
    }


        $url = ''.$portName.(($args==='&')?'':$args);
        $url = HTTP_APP_BASE . rtrim($url,'/');
    return 'http://'.$_SERVER['HTTP_HOST'].$url;
}

function uid() {
    $session = yiff\stdlib\registry::get('session');
    if ($session) {
        return $session->getUserId();
    }
    return 0;
}
