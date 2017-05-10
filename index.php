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
<?php include_once('search/form.php');
renderForm($db);
?>

<p/>
<h3><a href="/~ss013r/mechanics">Or: Browse Boardgame Mechanics</a></h3>

<?php include_once('footer.php'); ?>
