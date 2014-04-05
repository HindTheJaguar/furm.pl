<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */
echo '<h1>Historia: '.$this->meet->name.'</h1>';
echo '<a href="'.port('/meet/show/:id:',array('id'=>$this->meet->id)).'">&laquo; Powrót do meetu</a><br/><br/>';

echo '<ol>';
foreach ($this->history as $item) {
    echo '<li><a href="'.port('/meet/showhistory/:id:',array('id'=>$item->id)).'">Z dnia '.$item->date.'</a> przez <a href="'.port('/users/:login:',array('login'=>$item->user->login)).'">'.$item->user->name.'</a></li>';
}
echo '</ol>';
echo '<br />';
