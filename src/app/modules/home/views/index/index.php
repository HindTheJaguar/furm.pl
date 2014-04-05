<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */
echo $this->partial('home/views/options.php',array('selected'=>'index'));
?>
<form method="post">
<input type="hidden" name="action" value="update">
<div class="row">
    <div class="col-lg-6">
    <table>
    <tr>
      <th colspan=2>Konto: <?php echo $this->user->login;?></th>
    </tr>
    <tr>
      <td>Nazwa</td>
      <td><input type=text name=user[name] value="<?php echo $this->user->name;?>"></td>
    </tr>
    <tr>
      <td>Email</td>
      <td><input type=text name=user[mail] value="<?php echo $this->user->mail;?>"></td>
    </tr>
    <tr>
      <td>Pokazuj email</td>
      <td>
            <input type=hidden name=user[show_mail] value="0">
            <input type=checkbox name=user[show_mail] value="1"<?php if($this->show_mail) echo ' checked';?>> Tak
      </td>
    </tr>
    
    <tr>
    	<td>Wyświetlaj mój profil niezalogowanym osobom</td>
    	<td>
    		<input name="user[public_profile]" type="hidden" value="0" />
    		<input name="user[public_profile]" type="checkbox" value="1"<?php if($this->public_profile) echo ' checked';?> /> Tak
    	</td>
    </tr>
    <tr>
      <th colspan=2>Zmień hasło</th>
    </tr>
    <tr>
      <td>Stare hasło</td><td><input type=password name=old_pass></td>  
    </tr>
    <tr>
      <td>Nowe hasło</td><td><input type=password name=new_pass></td>  
    </tr>
    <tr>
      <td>Nowe hasło (jeszcze raz)</td><td><input type=password name=new_pass2></td>  
    </tr>
    
    </table>
    </div>
    <div class="col-lg-6">
      <div class="user-avatar">
  <img src="<?php echo gravatar($this->user->mail);?>" alt="gravatar"><br>
      </div>
  <a href="http://pl.gravatar.com/">Zmień avatar</a>
  <br>
  <div style="font-size:12px;">
    Usługę avatarów udostępnia zewnętrzny serwis gravatar.com
  </div>
  <!--<div>
      <a href="<?php echo port('/home/avatar');?>">Wgraj avatar</a>
  </div>-->
    </div>
</div>
    
    <input class="btn" type=submit value="zapisz" style="width:100%;">
   
</form>
