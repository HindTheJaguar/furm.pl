<?php
echo $this->partial('home/views/options.php',array('selected'=>'about'));
?>
<form method="post">
  <style>
    .tbl tr:hover {
      background: #ffff80;
}
  </style>
	<table style="width:90%" class="tbl">
      <colgroup>
        <col style="width:35%" />
        <col style="width:65%" />
      </colgroup>
<?php foreach ($this->list as $item):?>
		<tr>
			<td><?php echo $item->name ?></td>
            <td><input type="text" style="width:100%" name="option[<?php echo $item->id ?>]" value="<?php echo str_replace('<','&lt;',$item->value) ;?>" /></td>
		</tr>
<?php endforeach; ?>
		<tr>
			<td colspan=2><input type=submit value="Zapisz" /></td>
		</tr>
	</table>
</form>
