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
SELECT * FROM
(SELECT * FROM Boardgame WHERE id=$id) AS b

LEFT JOIN (SELECT gameID, GROUP_CONCAT(mechanicID SEPARATOR ',') AS mechanics FROM BoardgameMechanic bm WHERE bm.gameID=$id) AS mech ON b.id=mech.gameID

LEFT JOIN (SELECT gameID, GROUP_CONCAT(categoryID SEPARATOR ',') AS categories FROM BoardgameCategory bc WHERE bc.gameID=$id) AS cat ON b.id=cat.gameID

LEFT JOIN (SELECT gameID, GROUP_CONCAT(familyID SEPARATOR ',') AS families FROM BoardgameFamily bf WHERE bf.gameID=$id) AS fam ON b.id=fam.gameID

LEFT JOIN (SELECT gameID, GROUP_CONCAT(subdomainID SEPARATOR ',') AS subdomains FROM BoardgameSubdomain bs WHERE bs.gameID=$id) AS sub ON b.id=sub.gameID

LEFT JOIN (SELECT gameID, GROUP_CONCAT(personID SEPARATOR ',') AS designers FROM BoardgameDesigner bd WHERE bd.gameID=$id) AS des ON b.id=des.gameID

LEFT JOIN (SELECT gameID, GROUP_CONCAT(personID SEPARATOR ',') AS artists FROM BoardgameArtist ba WHERE ba.gameID=$id) AS art ON b.id=art.gameID

LEFT JOIN (SELECT baseID AS gameID, GROUP_CONCAT(expansionID SEPARATOR ',') AS expansions FROM BoardgameExpansion WHERE baseID=$id) AS exp ON b.id=exp.gameID

LEFT JOIN (SELECT expansionID AS gameID, GROUP_CONCAT(baseID SEPARATOR ',') AS bases FROM BoardgameExpansion WHERE expansionID=$id) AS base ON b.id=base.gameID

LEFT JOIN (SELECT implementationID as gameID, GROUP_CONCAT(originalID SEPARATOR ',') AS originals FROM BoardgameImplementation WHERE implementationID=$id) AS orig ON b.id=orig.gameID

LEFT JOIN (SELECT originalID as gameID, GROUP_CONCAT(implementationID SEPARATOR ',') AS implementations FROM BoardgameImplementation WHERE originalID=$id) AS impl ON b.id=impl.gameID

LEFT JOIN (SELECT gameID, GROUP_CONCAT(publisherID SEPARATOR ',') AS publishers FROM BoardgamePublisher bp WHERE bp.gameID=$id) AS pub ON b.id=pub.gameID;

EOQ;
  $r = $db->query($sql);
  renderForm($db, $r->fetch_assoc(), 'Edit');
}
include_once('../footer.php');
?>
