<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-07-16, 22:05:04
 */
echo $this->partial('home/views/options.php', array('selected' => 'pw'));

echo $this->partial('home/views/pw/menu.php');
echo '<h1>' . $this->page . '</h1>';
echo '<table class="table furm-table-hover">
    <colgroup>
        <col style="width:40px" />
        <col />
        <col style="width:30%"/>
        <col style="width:180px">
    </colgroup>
    <tr class="ui-widget-header">
        <th>Lp</th>
        <th>Temat</th>
        <th>Od</th>
        <th>Data</th>
    </tr>
    ';
$lp = 1;
$uid = uid();
try {
    foreach ($this->list as $v) {
        if ($v->user_id == $uid) {
            $user = $v->getRecv();
        } else {
            $user = $v->getSender();
        }
        echo '<tr>
            <td>' . ($lp++) . '</td>
            <td><a href="'.port('/home/pw/topic/' . $v->id . '#pwid' . $v->id) . '">' . $this->escape($v->topic) . '</a></td>
            <td><a href="' . $user->getUrl() . '">' . $user . '</a></td>
            <td>' . $v->getdate('created') . '</td>
            
          </tr>';
    }
    if ($lp === 1){
        throw new \yiff\stdlib\NoFound;
    }
} catch (\yiff\stdlib\NoFound $e) {
    echo '<tr><td colspan=4>Brak wiadomości</td></tr>';
}
echo '</table>';