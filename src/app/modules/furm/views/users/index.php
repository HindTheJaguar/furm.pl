<h1><?php echo $this->user->name; ?></h1>
<style>
    .users_tbl {
        border-collapse: collapse;
        font-size: 13px;
        width: 100%;
    }
    .users_tbl tr {
        border-bottom: 1px dotted orange;
    }
</style>

<?php if($this->show_home):?>
    <a href="/home">Edytuj profil</a>
<?php endif;?>
    <div style="float:right">
        <?php 
        if (in_array($this->user->login,array('dam_','etrii'))) {
            echo "Miss 2012";
        }
        ?>
    </div>
<table style="width:100%">
    <tr>
        <td style="width:50%" valign="top">
            <center>
                <div class="user-avatar">
                    <img src="<?php echo gravatar($this->user->mail);?>" alt="gravatar">
                </div>
            </center>
            <br>
            <a class="btn btn-furm" href="<?=port('/home/pw/new/user/'.$this->user->id);?>">Wyślij wiadomość</a> 
            <?php if (uid()) {
                if ($this->user->isMyFriend(uid())) {
                    echo '<a href="'.port('/home/friends/remove/'.$this->user->id).'" class="btn btn-default">Usuń ze znajomych</a>';
                } else {
                    echo '<a href="'.port('/home/friends/add/'.$this->user->id).'" class="btn btn-success btn">Dodaj ze znajomych</a>';
                }
            }
            ?>
        </td>
        <td style="width:50%" align="center" valign="top">
            <table class="users_tbl">
                <?php
                foreach ($this->list as $k => $v) {
                    if ($v->value) {
                        switch ($v->id) {
                            case 1:
                                echo '<tr><td>' . $v->name . '</td><td><a href="http://' . $v->value . '.deviantart.com">'.$v->value.'</a></td></tr>';
                                break;
                            case 2:
                                echo '<tr><td>' . $v->name . '</td><td><a href="http://www.furaffinity.net/user/' . $v->value .'">'.$v->value.'</a></td></tr>';
                                break;
                            case 3:
                                echo '<tr><td>' . $v->name . '</td><td><a href="http://www.youtube.com/' . $v->value .'">'.$v->value.'</a></td></tr>';
                                break;
                            case 6:
                                echo '<tr><td>' . $v->name . '</td><td><a href="gg:'. $v->value .'">'.$v->value.'</a></td></tr>';
                                break;

                            case 11:
                                echo '<tr><td>' . $v->name . '</td><td><a href="http://mapy.google.pl/maps?q=' . $v->value .'">'.$v->value.'</a></td></tr>';

                                break;
                            default:
                                echo '<tr><td>' . $v->name . '</td><td>' . $v->value . '</td></tr>';
                        }
                        
                    }
                }
                ?>
            </table>
        </td>
    </tr>
</table>
