<ul class="nav nav-tabs">
    <li<?php echo ($this->selected == 'index')?' class="active"':'';?>>
        <a href="<?php echo port('/home');?>">Dane podstawowe</a>
    </li>
    <li<?php echo ($this->selected == 'about')?' class="active"':'';?>>
        <a href="<?php echo port('/home/about');?>">Dane dodatkowe</a>
    </li>
    <li<?php echo ($this->selected == 'pw')?' class="active"':'';?>>
        <a href="<?=  port('/home/pw');?>">Wiadomości</a>
    </li>
    <!--li<?= (in_array($this->selected,['other','characters']))?' class="active"':'';?>>
        <a href="<?=port('/home/other')?>">Inne</a>
    </li-->
<!--        <a href="<?php echo port('/home/xmpphistory');?>">Konwersacje</a>
    </li>-->
    <!--li<?php echo ($this->selected == 'sessions')?' class="active"':'';?>>
        <a href="<?php echo port('/home/sessions');?>">Moje sesje</a>
    </li-->
</ul>
