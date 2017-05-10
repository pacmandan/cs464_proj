<?php
$title = 'Boardgame Mechanics';
include_once('../header.php');
require_once('../db.php');
require_once('../security.php');

include('render_mech_row.php');
/*Mechanic attributes: 'id', 'name', 'description'*/

$sql = "SELECT * FROM Mechanic ORDER BY name ASC;";

$r = $db->query($sql);
print(mysqli_num_rows($r).' Total Mechanics');
if(mysqli_num_rows($r) > 0) {
  print('<table class="mech-results-table">');
  while($row = $r->fetch_assoc()) {
    //print_r($row);
    //print('<br/>');
    render_mech_row($row, $db);
  }
  print('</table>');
}


require_once('../footer.php');
?>


