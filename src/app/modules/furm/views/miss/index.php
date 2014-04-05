<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-03-10, 17:30:59
 */
echo "Każdy posiada 2 nieodwracalne głosy!<br>";
echo "Oddanych głosów: ".$this->cnt."<br>";
//echo '<a href="'.port('/miss/add').'">Dodaj swoje zdjęcie</a>';
echo '<table border=1>';
$i=0;
foreach($this->list as $v) {
    if(!$i)
        echo '<tr>';
    echo '<td><a href="'.port('/miss/show/'.$v->id).'"><img src="'.port('/miss/thumb/'.$v->filename).'"></a><br><br>Punktów: '.$v->points().'
        <!--<a href="'.port('/miss/point/'.$v->id.'/minus').'">-</a> | <a href="'.port('/miss/point/'.$v->id.'/plus').'">+</a>--><br>
        Dodane przez: '.$v->getUser()->name.'</td>';
    
    $i++;
    if ($i > 3) {
        $i = 0;
        echo '</tr>';
    }
}

if($i)
    echo '</tr>';
echo '</table>';
