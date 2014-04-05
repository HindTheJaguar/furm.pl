<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */
if (!isset($this->selected)) {
    $selected = 'meet';
} else {
    $selected = $this->selected;
}
?>
<h1><?php echo $this->meet->name; ?></h1>
<div style="font-size:10px">
    <?php
    if ($this->meet->date_start == $this->meet->date_end)
        echo 'dnia ', $this->meet->date_start;
    else
        echo 'od ', $this->meet->date_start . ' do ' . $this->meet->date_end;

    echo ' / ', $this->meet->city;
    ?>
</div>

<ul class="nav nav-tabs">
    <li<?php echo ($selected == 'meet') ? ' class="active"' : ''; ?>><a href="<?php echo port('/meet/show/:id:', array('id' => $this->meet->id)); ?>">Informacje ogólne</a></li>
    <li<?php echo ($selected == 'news') ? ' class="active"' : ''; ?>><a href="<?php echo port('/meets/news/list/' . $this->meet->id); ?>">Wiadomości</a></li>
    <li<?php echo ($selected == 'cost') ? ' class="active"' : ''; ?>><a href="<?php echo port('/meets/costs/index/' . $this->meet->id); ?>">Cennik</a></li>
<?php if(isset($this->user) && $this->user instanceof yiff\auth\User):?>
    <li<?php echo ($selected == 'rooms') ? ' class="active"' : ''; ?>><a href="<?php echo port('/meets/rooms/list/' . $this->meet->id); ?>">Pokoje</a></li>
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            Opcje<span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <ul style="list-style:none;">
                <li><a href="<?php echo port('/meet/history/:id:', array('id' => $this->meet->id)); ?>">Historia</a></li>
                <li><a href="<?php echo port('/meet/edit/:id:', array('id' => $this->meet->id)); ?>">Edytuj</a></li>
                <?php if ($this->user->isAdmin()): ?>
                    <li><a href="<?php echo port('/adm/meet/delete/:id:', ['id' => $this->meet->id]); ?>" onclick="return confirm('Usunąć ?')">Usuń</a></li>
                <?php endif; ?>
            </ul>
        </ul>
    </li>
    <?php endif;?>
</ul>


