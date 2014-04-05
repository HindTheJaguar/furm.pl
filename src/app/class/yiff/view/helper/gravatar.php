<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 
 */

namespace yiff\view\helper;
class gravatar {
    public function gravatar($mail, $size = 100) {
          return "https://secure.gravatar.com/avatar.php?gravatar_id=".md5( strtolower($mail) ).
//"&default=".urlencode($this->default).
"&size=".$size;
    }
}