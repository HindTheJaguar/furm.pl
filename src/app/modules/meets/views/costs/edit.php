<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-03-16, 19:51:19
 */
?>
<h1><?php echo $this->meet->name; ?></h1>
<div style="font-size:10px">
    <?php
    if ($this->meet->date_start == $this->meet->date_end)
        echo 'dnia ', $this->meet->date_start;
    else
        echo 'od ', $this->meet->date_start . ' do ' . $this->meet->date_end;

    echo ' / ', $this->meet->getState(), ' / ', $this->meet->city;
    ?>
</div>

<?php
echo $this->form;
?>
<br>
<a href="<?php echo port('/meets/costs/index/'.$this->meet->id);?>"U>&laquo; Powrót</a>
<a href="<?php echo port('/meets/costs/delete/'.$this->meet->id.'/'.$this->cost->id);?>" onclick="return confirm('Usunąć?');">Usuń koszt z cennika</a>

<style>
#content-info {
    clear: both;
}
#field-info {
    height: auto;
}
</style>