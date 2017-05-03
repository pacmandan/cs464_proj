<?php
require_once('../db.php');
print('SEARCH TEST!<br/>');
$sql = 'SELECT COUNT(*) FROM Boardgame;';
$r = $db->query($sql);
while($row = $r->fetch_row()) {
    print($row[0].' Boardgames!<br/>');
}
?>