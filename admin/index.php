<?php
$title = 'Admin';
include_once('../header.php');
require_once('../db.php');
require_once('../security.php');
require('add-game-form.php');
renderForm($db, array(), 'Add');
?>

<?php
include_once('../footer.php');
?>
