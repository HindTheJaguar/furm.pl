<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-03-10, 19:15:22
 */

?>
<h1><?php echo $this->file->info;?></h1>
<?php echo $this->file->date;?><br>
<a href="<?php echo port('/miss');?>">&laquo; Powrót</a><br>
<img style="width:100%" src="<?php echo port('/miss/read/'.$this->file->filename);?>">