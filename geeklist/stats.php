<?php
$title = 'Geeklist Stats';
include_once('../header.php');
require_once('../db.php');
require_once('../security.php');
/*
Number of Geeklists
% of games in Geeklists
Most popular games in Geeklists
Average number of items in Geeklist
 */

$numSQL = <<<EOQ
SELECT COUNT(*) AS count FROM Geeklist;
EOQ;

$percentSQL = <<<EOQ
SELECT ( (SELECT COUNT(DISTINCT gameID) FROM GeeklistItemHasBoardgame) / (COUNT(b.id)) ) AS percentGames FROM Boardgame b;
EOQ;

$popularSQL = <<<EOQ
SELECT COUNT(*) AS count, gihb.gameID, b.thumbnail, b.primaryName FROM GeeklistItemHasBoardgame gihb JOIN Boardgame b ON b.id=gihb.gameID GROUP BY gihb.gameID ORDER BY count DESC LIMIT 3;
EOQ;

$avgSQL = <<<EOQ
SELECT AVG(gcount) AS average FROM (SELECT COUNT(*) AS gcount FROM GeeklistItemIn GROUP BY geeklistID) items;
EOQ;

$rNum = $db->query($numSQL);
$rPercent = $db->query($percentSQL);
$rPopular = $db->query($popularSQL);
$rAvg = $db->query($avgSQL);

$num = $rNum->fetch_row();
$percent = $rPercent->fetch_row();
$avg = $rAvg->fetch_row();
?>
<h2>Number of Geeklists: <?=$num[0]?></h2>
<h2>Percentage of games in Geeklists: <?=$percent[0]*100?>%</h2>
<h2>Average number of items per list: <?=$avg[0]?></h2>
<?php
print('<h2>Games appearing most frequently:</h2><br/>');
while($row = $rPopular->fetch_assoc()) {
  $thumb = $row['thumbnail'];
  $name = $row['primaryName'];
  $count = $row['count'];
  $id = $row['id'];
  print("<div><a href='/boardgame?id=$id'><img style='float:left' src='$thumb'/><h3 style='float:left'>$name: In $count Geeklists</h3></a></div><br style='clear:both'/><br/>");
}
?>



<?php
include_once('../footer.php');
?>
