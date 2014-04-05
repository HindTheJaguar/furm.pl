<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */

echo "Dodawanie pokoju do meetu <a href=\"".port('/meet/:id:',array('id'=>$this->meet->id)).'">'.$this->meet->name.'</a>';
echo '<div style="border:solid 1px orange;padding : 4px;">';
echo $this->form;
echo '</div>';


echo '<a href="'.port('/pokoje/meet/:id:',array('id'=>$this->meet->id)).'">&laquo; Powrót do pokojów</a>';
