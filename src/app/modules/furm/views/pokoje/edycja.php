<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */

echo "Edycja pokoju";
echo '<div style="border:solid 1px orange;padding : 4px;">';
echo $this->form;
echo '</div>';


echo '<a href="'.port('/pokoje/meet/:id:',array('id'=>$this->pokoj->meet_id)).'">&laquo; Powrót do pokojów</a>';
