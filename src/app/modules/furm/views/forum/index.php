<h1>Forum</h1>
Inne polskie fora futrzaste: 
<a href="http://futrzaki.org">Futrzaki.org</a> 
<a href="http://polfurs.org">Polfurs.org</a> 

<?php if (!$this->list) {
    ?>
<div style="border:solid 1px black; background-color: orange; padding: 10px; text-align:center;"><a href="<?php echo port('/forum/newtopic');?>">Dodaj temat</a>    </div>
<?php
    return;
}
?>
<table class="table furm-table-hover">
    <colgroup>
        <col style="width:70px;" />
        <col />
        <col style="width:200px;" />
        <col style="min-width:130px;width:18%" />
    </colgroup>
    <tr class="ui-widget-header" style="background-color: orange;">
        <th>Lp</th>
        <th>Nazwa</th>
        <th>Dodał</th>
        <th>Data odpowiedzi</th>
    </tr>
<?php
$i=1;
foreach($this->list as $v) {
    $user = $v->getUser();
    
    echo '<tr>
            <td>'.($i++).'</td>
            <td><a href="'.port('/forum/topic/:id:',array('id'=>$v->id)).'">'.$v->name.'</a></td>
            <td><a href="'.$user->getUrl().'">'.$user->name.'</a></td>
            <td style="font-size:10px;">'.$v->getDate('modified').'</td>
        </tr>';
}

?>
</table>

<a class="btn btn-furm" href="<?php echo port('/forum/newtopic');?>">Dodaj temat</a>