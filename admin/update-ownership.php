<?php
$title = 'Update Ownership';
include_once('../header.php');
require_once('../db.php');
require_once('../security.php');

$sql = <<<EOQ
UPDATE Boardgame b
       INNER JOIN
       	     (SELECT gameID, SUM(own) as numOwn, SUM(forTrade) AS numTrading
	     FROM CollectionItem GROUP BY gameID) AS totals
       ON b.id=totals.gameID
       SET b.numOwn=totals.numOwn, b.numTrading=totals.numTrading;
EOQ;

$db->query($sql);
if($db->error) {
  print('<br/>There was an error!');
  print('<br/>');
  print($db->error);
} else {
  print('Games updated successfully!');
}

?>
