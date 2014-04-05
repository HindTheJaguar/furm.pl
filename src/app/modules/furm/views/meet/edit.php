<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */
echo '<h1>Edycja: '.$this->meet->name.'</h1>';
echo $this->partial('furm/views/meet/edit_menu.php',array('meet'=>$this->meet));
echo $this->form;
echo '<br>';
echo '<a href="'.port('/meet/show/:id:',array('id'=>$this->meet->id)).'">&laquo; Powrót</a>';
?>

<style>
#content-content {
    clear: both;
}
#field-content {
    height: auto;
}
</style>