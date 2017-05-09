<?php
$title = 'Edit Game';
include_once('../header.php');
require_once('../db.php');
require_once('../security.php');
require('game-form.php');

//TODO: Get default values
if(isset($_GET['id'])) {
  $id = $_GET['id'];
  $sql = <<<EOQ
SELECT * FROM Boardgame WHERE id=$id;
EOQ;
  $r = $db->query($sql);
  renderForm($db, $r->fetch_assoc(), 'Edit');
}
include_once('../footer.php');
?>
