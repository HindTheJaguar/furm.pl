<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */
echo '<h1>Rejestracja</h1>';
echo $this->form;
include 'links.php';
?>
<script>
document.getElementsByTagName('form')[1].action = document.location+'';
</script>