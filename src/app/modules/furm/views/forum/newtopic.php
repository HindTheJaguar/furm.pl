<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-06-21, 15:55:51
 */
?>
<h1><?=$this->page;?></h1>

<form method="POST">
    <div class="form-group">
    <input class="form-control" name="topic">
    </div>
    <div class="form-group">
        Treść
    <textarea class="form-control" name="text"></textarea><br>
    </div>
    
    <input class="btn btn-success" type="submit" value="Zapisz">
    <input class="btn btn-warning" type="Reset" value="Wyczyść">
    
</form>

