<?php
$v = $this->news;
    echo '<h2><a href="'.port('/blog/show/:id:',array('id'=>$this->news->id)).'">'.$this->news->name.'</a></h2>';
    echo '<div style="font-size:10px">'.substr($v->date,0,10).' przez <a href="'.port('/users/:login:',array('login'=>$v->user->login)).'">'.$v->user->name.'</a></div>'.$v->content;
    if($this->news->topic_id) {
        echo 'komentarze';
    }

