<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */
?>
<style>
    .pokoje {
        border-collapse: collapse;
        width: 295px;
        float: left;
        margin-right: 5px
}
</style>
<?php

if($this->pokoje) {
    $i=0;
    foreach($this->pokoje as $pokoj) {
        $i++;
        echo '<table class="pokoje" border=1>
                <tr>
                    <th colspan=2>'.$pokoj->name.' (<a href="'.port('/pokoje/edycja/:id:',array('id'=>$pokoj->id)).'">edycja</a>)</th>
                </tr>';
        for($ii = 1 ; $ii <= $pokoj->miejsc ; $ii++) {
            echo '<tr><td>'.$ii.'</td><td><a href="'.port('/pokoje/addme/:id:/:miejsce:',array('id'=>$pokoj->id,'miejsce'=>$ii)).'">Zajmij</a></td></tr>';

        }


            echo '</table>';
            if ($i == 3) {
                echo '<div style="clear:both;padding:5px;"></div>';
                $i = 0;
            }
    }
} else {
    echo "Brak dostępnych pokojów, proszę najpierw dodać";
}

echo '<div style="clear:both;"></div><a href="'.port('/pokoje/dodaj/:id:',array('id'=>$this->meet->id)).'">Dodaj pokój</a>';