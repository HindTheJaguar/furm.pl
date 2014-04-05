<div id=desc>
    <?php
    echo $this->partial('/furm/views/meet/edit_menu.php', array(
        'meet' => $this->meet,
        'selected' => 'meet',
        'user' => $this->user,
    ));
    ?>
    <?php echo $this->meet->content; ?>
    <?php if ($this->meet->info_url): ?>
        <div id="info_url">Więcej info pod adresem: <a href="<?php echo port('/link/id/:id:/name/:name:', array('id' => $this->meet->id, 'name' => urlchr($this->meet->name))); ?>"><?php echo htmlentities($this->meet->info_url); ?></a></div>
    <?php endif; ?>

</div>

<div class="row">
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">Uczestnicy</div>
            <div class="panel-body">
                <?php if (uid()): ?>
                    <form method=post action="<?php echo port('/addme/meet/:id:', array('id' => $this->meet->id)); ?>">
                        <?php if ($this->have): ?>
                            <input type=hidden name=watch value=0><input type=submit value='Rezygnuj'>
                        <?php else: ?>
                            <select name=prio>
                                <option class=meete_9 value=9>Na pewno będę</option>
                                <!--option class=meete_4 value=4>Raczej będę</option-->
                                <!--option class=meete_3 value=3>50/50</option-->
                                <option class=meete_2 value=2>Jeszcze nie wiem</option>
                                <option class=meete_1 value=0>Nie będę</option>
                            </select><input type=submit value='Dołącz'>
                        <?php endif; ?>
                    </form>
                <?php endif; ?>

                <?php 
                $users = [];
                foreach ($this->users as $v) {
                    $users[(in_array($v->prio,[0,9])?$v->prio:2)][] = $v;
                }
                if (isset($users[9])) {
                echo '<b>Będę:</b><br>';
                foreach ($users[9] as $v):
                    ?>
                    <div style="float:left;">
                        <a href="<?php echo port('/users/:login:', array('login' => $v->user->login)); ?>" title="<?php echo $v->user->name; ?>">
                            <div class="user-avatar">
                                <img style="height:80px" alt="<?php echo $v->user->name; ?>" src="<?php echo gravatar($v->user->mail); ?>">
                            </div>
                        </a>
                    </div>
                <?php endforeach; 
                }
                if (isset($users[2])) {
                echo '<div style="clear:both;"></div>'
                    . '<b>Zastanawiam się:</b><br>';
                foreach ($users[2] as $v):
                    ?>
                
                
                    <div style="float:left;">
                        <a href="<?php echo port('/users/:login:', array('login' => $v->user->login)); ?>" title="<?php echo $v->user->name; ?>">
                            <div class="user-avatar">
                                <img style="height:80px" alt="<?php echo $v->user->name; ?>" src="<?php echo gravatar($v->user->mail); ?>">
                            </div>
                        </a>
                    </div>
                <?php endforeach; }
                if (isset($users[0])) {
                echo '<div style="clear:both;"></div>'
                    . '<b>Nie będę:</b><br>';
                foreach ($users[0] as $v):
                    ?>
                
                
                    <div style="float:left;">
                        <a href="<?php echo port('/users/:login:', array('login' => $v->user->login)); ?>" title="<?php echo $v->user->name; ?>">
                            <div class="user-avatar">
                                <img style="height:80px" alt="<?php echo $v->user->name; ?>" src="<?php echo gravatar($v->user->mail); ?>">
                            </div>
                        </a>
                    </div>
                <?php endforeach; }?>
                
                
                
                <div style="clear:both;"></div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-body">

                <!--b>Kopiuj adres</b><br/-->
                <!--img style="margin:10px;" src="<?php // echo $this->qrcode('http://'.$_SERVER['HTTP_HOST'].core::url('meet.'.$this->meet['id'],'mobile'));      ?>" alt="qrcode" /><br /-->
                Adres bezpośredni<br />
                <input style="width:250px;border:solid 1px orange;" onfocus="this.style.border = 'solid 1px orangered'" onblur="this.style.border = 'solid 1px orange'" type="text" value="<?php echo $this->canonical; ?>"><br />
                Na forum<br />
                <input style="width:250px;border:solid 1px orange;" onfocus="this.style.border = 'solid 1px orangered'" onblur="this.style.border = 'solid 1px orange'" type="text" value="[URL=<?php echo $this->canonical; ?>]<?php echo $this->meet->name; ?>[/URL]">
                <br />
                <!-- AddThis Button BEGIN -->
                <!--
                <div class="addthis_toolbox addthis_default_style ">
                <a href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4cf3c16a73b32be8" class="addthis_button_compact">Share</a>
                -->
                <b>Dodaj do ulubionych</b> <br />
                <div class="addthis_toolbox addthis_32x32_style addthis_default_style">
                    <a class="addthis_button_facebook"></a>
                    <a class="addthis_button_twitter"></a>
                    <a class="addthis_button_email"></a>
                    <a class="addthis_button_google"></a>
                    <a class="addthis_button_compact"></a>
                </div>

                <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4cf3c16a73b32be8"></script>
                <!-- AddThis Button END -->
            </div>
        </div>
    </div>
    <div class="col-lg-8">

        <div style="font-weight:bold;font-size:20px">Komentarze</div>
        <a name="comments"></a>
        <?php
        include 'comments.php';
//$this->append('comments');
        ?>

    </div>
</div>

