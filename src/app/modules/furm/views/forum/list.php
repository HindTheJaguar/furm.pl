<table border="1">
    <tr>
        <th>Temat</th>
        <th>Odpowiedzi</th>
        <th>Czytany</th>
        <th>Założył</th>
        <th>Ostatnia odpowiedź</th>
    </tr>
<?php
foreach($this->topics as $v) {
    echo '<tr>';
    echo '<td><a href="'.port('/forum/topic/:id:',array('id'=>$v->id)).'">'.$this->escape($v->name).'</a></td>';
    echo '<td>'.$v->count.'</td>';
    echo '<td>'.$v->reads.'</td>';
    echo '<td>'.$v->date('date_created').'<br />'.$v->create_uid.'</td>';
    echo '<td>'.$v->date('date_last').'<br />'.$v->last_uid.'</td>';

    echo '</tr>';
}
echo '</table>';
?>
</table>
<a href="<?php echo port('/forum/add',array('category'=>$this->category->id,'type'=>'topic')) ;?>">Dodaj post</a>