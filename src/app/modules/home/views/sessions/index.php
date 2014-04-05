<?php
$this->page = 'Sesje';
echo $this->partial('home/views/options.php',array('selected'=>'sessions'));
?>
<style>
table#session-tbl
{
border-collapse:collapse;
width:100%;
}
table#session-tbl ,#session-tbl td,#session-tbl th
{
border:1px solid black;
}
</style>
<table id=session-tbl>
  <tr>
<!--    <th>Id</th> -->
    <th>Data</th>
    <th>IP</th>
    <th>UserAgent</th>
    <th>Wyloguj</th>
  </tr>
<?php
$sesid = session_id();
foreach($this->sessions as $r) {
  echo '<tr style="font-size:9px;'.(($sesid == $r['session_id'])?'background:#fed;':'').'">
<!--    <td>'.$r['id'].'</td>-->
    <td>'.date('Y-m-d H:i:s',$r['modified']+$r['ttl']).'</td>
    <td>'.$r['ip'].'</td>
    <td>'.$r['Agent'].'</td>
    <td><a href="'.port('/home/session/logout/:session:',array('session' => $r['session_id'])).'">Wyloguj</a></td>
  </tr>';
}
?>
</table>
