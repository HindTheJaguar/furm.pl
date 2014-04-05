<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */

foreach($this->news as $v) {
    echo '<h2><a href="'.port('/blog/show/:id:',array('id'=>$v->id)).'">'.$v->name.'</a></h2>';
    echo '<div style="font-size:10px">'.substr($v->date,0,10).' przez <a href="'.port('/users/:login:',array('login'=>$v->user->login)).'">'.$v->user->name.'</a></div>'.$v->content;
    if($v->topic_id) {
        echo 'komentarze';
    }
    echo '<hr>';
//    print_r($v->toArray());echo'<hr>';
}
