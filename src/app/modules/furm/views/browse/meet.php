<table class="table furm-table-hover" id="xtbl2">
    <tr class="ui-widget-header">
        <th style="width:50%">Nazwa</th>
        <th>Data</th>
        <th>Miejsce</th>
    </tr>

    <?php
    $t = time();
    foreach ($this->list as $r) {
        echo '<tr><td>';
        echo '<a href="' . $r->getUrl() . '">' . $r->name . '</a></td>';
//    if($t>$r['date_start'])
//      echo '<td style="background:#bfa">';
//      else
        echo '<td>';
        $ds = substr($r->date_start, 0, 10);
        $de = substr($r->date_end, 0, 10);
        if ($ds === $de) {
            echo 'Dnia ' . $ds;
        } else {
            echo 'Od ' . $ds . ' do ' . $de;
        }
        //.'</td>';
//    if($t>$r['date_end'])
//      echo '<td style="background:#fbb">';
//      else
//      echo '<td>';
        echo '</td><td>';
//    echo '</td><td>';
        echo $r->city;
        echo '</td>';
        echo '</tr>';
    }
    ?>
</table>
