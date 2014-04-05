<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */

$this->meet = $this->item->getContent();
?>
<div style="border: 1px;">
    <a href="<?php echo port('/meet/history/:id:',array('id'=>$this->item->meet_id));?>">&laquo; Powrót do historii</a>
</div>
<div id=desc>
    <h1><?php echo $this->meet->name; ?></h1>
    <div style="font-size:10px">
        <?php
        if ($this->meet->date_start == $this->meet->date_end)
            echo 'dnia ', $this->meet->date_start;
        else
            echo 'od ', $this->meet->date_start . ' do ' . $this->meet->date_end;

        echo ' / ', $this->item->getState(), ' / ', $this->meet->city;
        ?>
    </div>
    <br />
    <?php echo $this->meet->content; ?>
    <?php if ($this->meet->info_url): ?>
            <div id="info_url">Więcej info pod adresem: <a href="<?php echo port('/link/id/:id:/name/:name:', array('id' => $this->meet->id, 'name' => urlchr($this->meet->name))); ?>"><?php echo htmlentities($this->meet->info_url); ?></a></div>
    <?php endif; ?>

</div>
