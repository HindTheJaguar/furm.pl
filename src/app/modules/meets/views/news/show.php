<?php
/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-07-11, 19:15:26
 */
?>
<h1><a href="<?= $this->news->getUrl(); ?>"><?= $this->news->name; ?></a></h1>
<div style="font-size: 10px">
    ~<a href="<? $this->news->getUser()->getUrl(); ?>"><?= $this->news->getUser(); ?></a> 
    <?= $this->news->getDate('date'); ?> 
    <a href="<?= $this->news->getMeet()->getUrl(); ?>"><?= $this->news->getMeet(); ?></a>
</div>

<div class="news-content"><?= $this->news->content; ?></div>
