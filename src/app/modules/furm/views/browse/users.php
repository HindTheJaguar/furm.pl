<?php
echo '<ul class="btn-group">';
echo '<li class="btn btn-default"><a href="'.port('/browse/users').'">Wszystkie</a></li>';
for($i='A';$i<'Z';$i++) {
  echo '<li class="btn btn-default"><a href="'.port('/browse/users/:letter:',array('letter'=>$i)).'">'.$i.'</a></li>';
}
echo '<li class="btn btn-default"><a href="'.port('/browse/users/:letter:',array('letter'=>$i)).'">'.$i.'</a></li>';
echo '<li class="btn btn-default"><a href="'.port('/browse/users/:letter:',array('letter'=>'123')).'">123</a></li>';
echo '</ul>';
echo '<br />';
if (count($this->users)):
?>

<table class="table furm-table-hover">
    <tr class="ui-widget-header">
        <th>Awatar</th>
        <th>Nazwa</th>
        <th>PW</th>
        <th>Ostatnio zalogowany</th>

<?php foreach($this->users as $user):?>
    <tr>
        <td><div class="user-avatar"><img src="<?php  echo gravatar($user->mail);?>"></div></td>
        <td><a title="<?php echo $user->name;?>" href="<?php echo port('/users/:login:',array('login'=>$user->login));?> "><?php echo $user->name ;?></a></td>
        <td><a href="<?php echo port('/home/pw/new/user/'.$user->id);?>">Nowa wiadomość</a></td>
        <td><?php echo substr($user->date_last_login,0,10);?></td>
    </tr>
<?php endforeach; ?>
</table>
<?php
else:
//msg::add('Brak futer');
?>
Lista jest pusta

<?php endif ;?>
