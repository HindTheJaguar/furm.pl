<?php
/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-07-16, 22:13:36
 */
$cnt = count($this->list);
$id = $this->msg->id;
echo 'Liczba wiadomości w wątku: <b>' . $cnt . '</b>';
echo '<br>';
foreach ($this->list as $v) :
    $user = $v->getSender();
    ?>

    <a id="pwid<?php echo $v->id; ?>"></a>
    
    <div class="furm-ui-border" style="margin-bottom:10px;<?php if ($id == $v->id) {
        echo 'border:solid 2px black;';
    }; ?>">
        <div class="ui-widget-header">
            <div style="float:right;">
                <!--a href="<?= port('/home/pw/delete/' . $v->id); ?>">Usuń</a-->
            </div>
            <div style="float:left" class="user-avatar"> <img src="<?= $this->gravatar($user->mail,50); ?>"></div>
            <?php echo $user->name; ?>
        </div>
        
        <div style="padding-left:60px">
            
            <div class="forum-topic-date"><?= $this->escape($v->topic); ?> z dnia <?php echo $v->getDate('created'); ?></div>
            <?php
            echo $this->escape($v->body);
            ?>
        </div>
        <div class="clear"></div>
    </div>
    


<?php endforeach; ?><br>
<a class="btn btn-furm" href="<?= $this->url; ?>">Odpowiedz</a>