<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-03-16, 19:41:17
 */

echo $this->partial('/furm/views/meet/edit_menu.php',array(
    'meet'=>$this->meet,
    'selected'=>'cost',
));

echo '<a href="'.port('/meets/costs/add/'.$this->meet->id).'">Dodaj koszt do cennika</a>';

if (! count ($this->list)) {
    echo '<b>Brak cennika</b>';
    return;
}
echo '<table class="table">
    <colgroup>
        <col style="width:200px;"></col>
        <col></col>
        <col style="width:100px;"></col>
    </colgroup>
    <tr class="ui-widget-header">
        <th>Nazwa</th>
        <th>Opis</th>
        <th>Koszt</th>
    </tr>';
foreach ($this->list as $cost) {
    echo '
        <tr>
            <td><a href="'.port('/meets/costs/edit/'.$this->meet->id.'/'.$cost->id).'">'.$cost->name.'</a></td>
            <td>'.$cost->info.'</td>
            <td>'.$cost->cost.'</td>
        </tr>
';
}
echo '</table>';
?>
<br>
<i>Cennik może zawierać informacjie nie prawdziwe, dane tutaj zawarte nie są w żaden sposób sprawdzane!</i>