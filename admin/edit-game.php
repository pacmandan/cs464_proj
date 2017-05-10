<?php
$title = 'Edit Game';
include_once('../header.php');
require_once('../db.php');
require_once('../security.php');

$gameFields = array(
  'primaryName', 'minPlayers', 'maxPlayers',
    'playerAge', 'playingTime', 'maxPlaytime', 'minPlaytime',
    'yearPublished', 'description', 'thumbnail',
    'avgRating', 'avgWeight',
    'numRated', 'numWeighted'
);
$linkFields = array(
  'mechanics', 'categories', 'subdomains', 'families',
    'expansions', 'bases', 'originals', 'implementations',
    'publishers', 'artists', 'designers'
);
$stringFields = array(
  'primaryName', 'description', 'thumbnail'
);

$fieldNames = array_intersect($gameFields, array_keys($_POST));
$fields = array_intersect_key($_POST, array_flip($fieldNames));
$id = $_POST['id'];

$sql = "START TRANSACTION; UPDATE Boardgame SET ";
$fieldStrings = array();
foreach($fields as $name=>$value) {
  if(in_array($name, $stringFields)) {
    $fieldStrings[] = $name." = '".$value."'";
  } else {
    $fieldStrings[] = $name." = ".$value;
  }
}
$sql .= implode(',',$fieldStrings)." ";
$sql .= "WHERE id=$id;";

//Build link fields
if(isset($_POST['mechanics'])) {
  //loop through mechanics, add SQL statement for each
  $sql .= "DELETE FROM BoardgameMechanic WHERE gameID = $id;";
  $mechs = explode(',',$_POST['mechanics']);
  foreach($mechs as $mechID) {
    $sql .= "INSERT INTO BoardgameMechanic(mechanicID, gameID) VALUES ($mechID, @nextID);";
  }
}

if(isset($_POST['categories'])) {
  $sql .= "DELETE FROM BoardgameCategory WHERE gameID = $id;";
  $cats = explode(',',$_POST['categories']);
  foreach($cats as $catID) {
    $sql .= "INSERT INTO BoardgameCategory(categoryID, gameID) VALUES ($catID, @nextID);";
  }
}

if(isset($_POST['families'])) {
  $sql .= "DELETE FROM BoardgameFamily WHERE gameID = $id;";
  $fams = explode(',',$_POST['families']);
  foreach($fams as $famID) {
    $sql .= "INSERT INTO BoardgameFamily(familyID, gameID) VALUES ($famID, @nextID);";
  }
}

if(isset($_POST['subdomains'])) {
  $sql .= "DELETE FROM BoardgameSubdomain WHERE gameID = $id;";
  $subs = explode(',',$_POST['subdomains']);
  foreach($subs as $subID) {
    $sql .= "INSERT INTO BoardgameSubdomain(subdomainID, gameID) VALUES ($subID, @nextID);";
  }
}

if(isset($_POST['publishers'])) {
  $sql .= "DELETE FROM BoardgamePublisher WHERE gameID = $id;";
  $pubs = explode(',',$_POST['publishers']);
  foreach($pubs as $pubID) {
    $sql .= "INSERT INTO BoardgamePublisher(publisherID, gameID) VALUES ($pubID, @nextID);";
  }
}

if(isset($_POST['designers'])) {
  $sql .= "DELETE FROM BoardgameDesigner WHERE gameID = $id;";
  $designers = explode(',',$_POST['designers']);
  foreach($designers as $personID) {
    $sql .= "INSERT INTO BoardgameDesigner(personID, gameID) VALUES ($personID, @nextID);";
  }
}

if(isset($_POST['artists'])) {
  $sql .= "DELETE FROM BoardgameArtist WHERE gameID = $id;";
  $artists = explode(',',$_POST['artists']);
  foreach($artists as $personID) {
    $sql .= "INSERT INTO BoardgameArtist(personID, gameID) VALUES ($personID, @nextID);";
  }
}

if(isset($_POST['expansions'])) {
  $sql .= "DELETE FROM BoardgameExpansion WHERE baseID = $id;";
  $expansions = explode(',',$_POST['expansions']);
  foreach($expansions as $expansionID) {
    $sql .= "INSERT INTO BoardgameExpansion(baseID, expansionID) VALUES (@nextID, $expansionID);";
  }
}

if(isset($_POST['bases'])) {
  $sql .= "DELETE FROM BoardgameExpansion WHERE expansionID = $id;";
  $bases = explode(',',$_POST['bases']);
  foreach($bases as $baseID) {
    $sql .= "INSERT INTO BoardgameExpansion(baseID, expansionID) VALUES ($baseID, @nextID);";
  }
}

if(isset($_POST['implementations'])) {
  $sql .= "DELETE FROM BoardgameImplementation WHERE originalID = $id;";
  $implementations = explode(',',$_POST['implementations']);
  foreach($implementations as $implID) {
    $sql .= "INSERT INTO BoardgameImplementation(originalID, implementationID) VALUES (@nextID, $implementations);";
  }
}

if(isset($_POST['originals'])) {
  $sql .= "DELETE FROM BoardgameImplementation WHERE implementationID = $id;";
  $originals = explode(',',$_POST['originals']);
  foreach($originals as $origID) {
    $sql .= "INSERT INTO BoardgameImplementation(originalID, implementationID) VALUES ($origID, @nextID);";
  }
}

$sql .= "COMMIT;";
//print($sql);

$r = $db->multi_query($sql);
if($db->error) {
  print('<br/>There was an error updating the game!');
  print('<br/>');
  print($db->error);
} else {
  print('Game updated successfully!');
}

include_once('../footer.php');
?>
