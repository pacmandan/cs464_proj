<?php
$title = 'Admin';
include_once('../header.php');
require_once('../db.php');
require_once('../security.php');
require('game-form.php');
?>
<a href="/~ss013r/admin/update-ownership.php"><h2>Update Ownership</h2></a>
<h2>Edit Game</h2>
<form action="/~ss013r/admin/edit-game-form.php">
  <label>ID:</label><input type="text" name="id"/>
  <input type="submit" value="Find and Edit"/>
</form>
<h2>Delete Game</h2>
<form action="/~ss013r/admin/delete-game.php" method="post">
  <label>ID:</label><input type="text" name="id"/>
  <input type="submit" value="Delete"/>
</form>
<?php
renderForm($db, array(), 'Add');
include_once('../footer.php');
?>
