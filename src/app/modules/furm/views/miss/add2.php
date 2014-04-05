<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-03-10, 17:57:55
 */

?>
<form method="post" action="<?php echo port('/miss/cfx');?>">
    <input type="submit" value="Zatwierdź" />
</form>

<?php echo $this->info;?><br>
<img src="<?php echo port('/miss/readtmp/'.$this->file);?>" />
