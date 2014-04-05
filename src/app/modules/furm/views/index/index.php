<div class="row">
    <div class="col-md-3">

        <?php
        if (!$this->access->isGuest()) {
            echo '<div class="panel panel-default">';

            $user = $this->access;
            echo '<div class="panel-heading">' . $user->getName() . '</div>';
            echo '<div class="panel-body">';
            echo '<center><div class="user-avatar"><img src="' . gravatar($user->mail) . '" /></div><br />';
            echo $user->getName();
            echo '<br /></center>';

            echo '<a href="' . port('/home') . '">Edycja profilu</a><br />
    <a href="' . port('/home/pw') . '">Wiadomości prywatne</a><br />                
    <a href="' . port('/users/:name:', array('name' => $user->getLogin())) . '">Konto</a><br />
    <a href="' . port('/auth/logout') . '">Wyloguj</a></div></div>';
        } else {
            echo '<div class="panel panel-default"><div class="panel-body">';
            echo '<a href="' . port('/auth/login') . '">Zaloguj się</a><br />
                <a href="' . port('/auth/register') . '">Zarejestruj się</a><br />';
            echo '</div></div>';
        }
        ?>
        <?php if (count($this->last)) { ?>
            <div class="panel panel-default">
                <div class="panel-heading">Przeszłe meety</div>
                <div class="panel-body">
                    <?php
                    echo '<ul class="list-group">';
                    foreach ($this->last as $v) {
                        echo '<li class="list-group-item"><a href="' . port('/meet/show/:id:/:name:', array('id' => $v->id, 'name' => urlchr($v->name))) . '">' . $v->name . '</a><br>' . substr($v->date_end, 0, 10) . '</li>';
                    }
                    echo '</ul>';
                    ?>
                </div>
            </div>
            <?php
        }
        ?>

        <div class="panel panel-default">
            <div class="panel-heading">Linki</div>
            <div class="panel-body">
                <a href="http://www.polfurs.org">Polfurs</a><br />
                <a href="http://pl.wikifur.com/wiki/WikiFur_Polska">WikiFur Polska</a><br />
                <a href="http://www.futrzaki.org">Futrzaki.org</a><br />
                <a href="https://rys.wwf.pl/"><img src="<?php echo HTTP_CDN; ?>ratujmy.png" style="width:155px"></a><br />
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Szukaj</div>
            <div class="panel-body">
                <form action="http://www.google.com/cse" id="cse-search-box" target="_blank">
                    <div>
                        <input name="cx" value="018071997553107647111:yqsgum9bea8" type="hidden">
                        <input name="ie" value="UTF-8" type="hidden">
                        <input name="q" style="width: 130px;" type="text">
                        <input name="sa" value="Szukaj" type="submit">
                    </div>
                </form>
            </div>
        </div>

    </div>
    <div class="col-md-9">

        <?php
        if (count($this->meets)) {
            foreach ($this->meets as $v) {

                echo '<div class="panel panel-default" style="-background: #feb">';
                echo '<div class="panel-heading"><a href="' . $v->getUrl() . '">' . $v->name . '</a></div>';
                echo '<div class="panel-body"><div style="font-size:10px">';
                if ($v->date_start == $v->date_end)
                    echo 'dnia ', substr($v->date_start, 0, 10);
                else
                    echo 'od ', substr($v->date_start, 0, 10) . ' do ' . substr($v->date_end, 0, 10);
                echo ' / ', $v->getState(), ' / ', $v->city;
                echo '</div>';
                echo $v->content;
                echo '<br />';
                echo '<a class="btn btn-sm btn-furm" href="' . $v->getUrl() . '">Zobacz więcej</a> ';
                echo '<a class="btn btn-sm btn-furm" href="' . $v->getUrl() . '#comments">Komentarze</a> ';
                if ($v->info_url)
                    echo '<a class="btn btn-sm btn-furm" href="' . port('/link/id/:id:/name/:name:', array('id' => $v->id, 'name' => $v->name)) . '">Strona Meetu</a>';
                echo'</div></div>';
//            echo '<br />';
            }
        } else {
            echo '<div class="panel panel-default">'
            . '<div class="panel-body">Brak meetów w najbliższej przyszłości</div>'
            . '</div>';
        }
        ?>
    </div>
</div>