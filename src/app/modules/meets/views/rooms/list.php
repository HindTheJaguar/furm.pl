<?php
/**
 * System EKL
 * 
 * @author Przemysław 'Hind' Jakubowski <przemyslaw.jakubowski@pkp-cargo.eu>
 * @date 2014-02-17, 15:52:14
 * 
 * Opis zmian:
 * 2014-02-17:
 * -Utworzenie pliku
 */
$this->page = $this->meet;
echo $this->partial('furm/views/meet/edit_menu.php', [
    'selected' => 'rooms',
    'meet' => $this->meet,
    'user' => $this->user,
]);
?>
<a class="btn btn-furm" href="<?=
   $this->url([
       '_module' => 'meets',
       '_controller' => 'rooms',
       '_action' => 'add',
       'id' => $this->meet->id]);
   ?>" onclick="addRoom();
           return false;">Dodaj pokój</a>


<?php
$b = 0;
echo '<div class="row">';
$lastRoomGroup = '';
foreach ($this->rooms as $room) {
    $b++;
    
    $b%2&&print('</div><div class="row">');
    $lst=[];
    echo '<div class=col-md-6>';
    echo '<div class="panel panel-default">';
    $i = 0;
    echo '<div class="panel-heading">'.$room->name.'</div>';
    echo '<div class="panel-body">';
    echo '<ol>';
    foreach ($room->getOccupants() as $occupant) {
        $i++;
        $lst[$occupant->user_id] = 1;
        echo '<li>' .$this->users->resolv($occupant->user_id) . '</li>';
    }

    for ($j = $i; $j < $room->size; $j++) {
        echo '<li>-</li>';
    }
    echo '</ol>';
    if ($j<>$i) {
        echo '<a href="'.$this->url([
            '_action'=>'join',
            '_module'=>'meets',
            '_controller'=>'rooms',
            'id'=>$this->meet->id,
            'room'=>$room->id,
        ]).'" class="btn btn-furm">Przłącz się</a>';
    }
    if (isset($lst[uid()])) {
        echo ' <a class="btn btn-furm" href="'.$this->url([
            '_action'=>'leave',
            '_controller'=>'rooms',
            '_module'=>'meets',
            'id'=>$this->meet->id,
            'room'=>$room->id
        ]).'">Opóść pokój</a>';
    }
    
    echo '</div>';
    echo '</div>';
    echo '</div>';
}
echo '</div>';
?>
