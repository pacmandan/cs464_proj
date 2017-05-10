<?php
$title = 'Delete Game';
include_once('../header.php');
require_once('../db.php');
require_once('../security.php');

if(isset($_POST['id'])) {
  $id = $_POST['id'];
  $sql = <<<EOQ
START TRANSACTION;
DELETE FROM BoardgameMechanic WHERE gameID = $id;
DELETE FROM BoardgameCategory WHERE gameID = $id;
DELETE FROM BoardgameFamily WHERE gameID = $id;
DELETE FROM BoardgameSubdomain WHERE gameID = $id;
DELETE FROM BoardgamePublisher WHERE gameID = $id;
DELETE FROM BoardgameDesigner WHERE gameID = $id;
DELETE FROM BoardgameArtist WHERE gameID = $id;
DELETE FROM BoardgameExpansion WHERE baseID = $id;
DELETE FROM BoardgameExpansion WHERE expansionID = $id;
DELETE FROM BoardgameImplementation WHERE originalID = $id;
DELETE FROM BoardgameImplementation WHERE implementationID = $id;
DELETE FROM Boardgame WHERE id=$id;
COMMIT;
EOQ;

  $db->multi_query($sql);
  if($db->error) {
    print('<br/>There was an error!');
    print('<br/>');
    print($db->error);
  } else {
    print('Game deleted successfully!');
  }
}
include_once('../footer.php');
?>
