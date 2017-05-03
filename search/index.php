<?php
$title = 'Find Games';
include_once('../header.php');
require_once('../db.php');
require_once('../security.php');

if(isset($_GET['name'])) {
	include('render_bg_row.php');
	$name = $_GET['name'];
	$sql = <<<EOQ
		 SELECT * FROM Boardgame WHERE primaryName LIKE '$name%';
EOQ;
	$r = $db->query($sql);
	print(mysqli_num_rows($r).' Results');
	if(mysqli_num_rows($r) > 0) {
		print('<table>');
		while($row = $r->fetch_assoc()) {
			render_bg_row($row);
		}
		print('</table>');
	}
}

require_once('../footer.php');
?>