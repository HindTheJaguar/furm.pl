<?php
foreach($this->comments as $k=>$v) {
?>
<a name="comment-<?php echo $v->id;?>"></a>
<?php


    if($v->tree_id !== $v->id) {
        $pd = ' style="margin-left:20px;margin-bottom:5px;"';
    } else {
        $pd = ' style="margin-bottom:5px;"';
    }

    if($v->deleted) {
echo '    <table class="commentstbl"'.$pd.'><tr><td>';
        echo "Komentarz usunięty</td></tr></table>";
        continue;
    }
?>

<table class="commentstbl"<?php echo $pd; ?>>
  <tr>
      <td rowspan=2 style="width:55px;" valign=top><div class="user-avatar"><img src="<?php echo gravatar($v->user->mail,50);?>"></div></td>
    <td class="tcbar ui-widget-header"><?php echo $v->user->name ;?><div style='float:right;color:white;font-size:13px;'>
    <?php echo $v->date;?>
    <a href="#comment-<?php echo $v->id;?>">#<?php echo $v->id;?></a>
    <a href="<?php echo port('/addme/deletecomment/:id:',array('id'=>$v->id));?>" title="usuwanie">d</a></div>
    </td>
  </tr>
  <tr>
    <td style='vertical-align:top; font-size: 12px;'><?php echo $v->content ?>
</td>
  </tr>
  <?php if($v->tree_id === $v->id) {
    echo "<tr rowspan=2><td><a href=\"#comment-box\" onclick=\"replyTo({$v->tree_id},'Odpowiedz ".htmlentities($v->user->name)."')\">Odpowiedz</a></td></tr>";
  }
  ?>
</table>


<?php    
    
}


?>
<a name="comment-box"></a>
<form method="POST" action="<?php echo port('/addme/comment/:id:',array('id'=>$this->meet->id));?>">
    <div id="reply-to"></div>
    <input type=hidden id="tree-id" value="0" name="tree_id" />
    <textarea name="content" id="element-text"></textarea><br />
    <input type="submit" value="Zapisz"/> <input type="reset" value="Anuluj" onclick="replyTo(0,'');"/>
</form>

    <div style="font-size: 12px;">pozostało znaków <span id="chl">2000</span>
    <br>
    '''<i>Pochylenie</i>'''<br>
    ''<b>Pogróbienie</b>''<br>
    ---<strike>Przekreślenie</strike>---
    </div>
<style>
  #element-text {
  width:100%;
  }
  #field-html div {
  display:inline;
  }
</style>


<script>
  var comment_text = document.getElementById('element-text');
  var comment_counter = document.getElementById('chl');

  comment_text.onkeyup = function() {
    comment_counter.innerHTML = 2000 - comment_text.value.length;
  }
  
 function replyTo(id,html) {
    document.getElementById('tree-id').value = id;
    document.getElementById('reply-to').innerHTML = html; 
 }
</script>




