<?php
$title = 'BGG Search';
include_once('header.php');
require_once('db.php');
require_once('security.php');

$sql = 'SELECT COUNT(*) FROM Boardgame;';
$r = $db->query($sql);
while($row = $r->fetch_row()) {
    print($row[0].' Boardgames!<br/>');
}
?>
<form action='/search'>
  <h3>Search for games</h3>
  <input type='text' name='name' />
  <input type='submit' value='Search'/>
</form>
<?php include_once('footer.php'); ?>
