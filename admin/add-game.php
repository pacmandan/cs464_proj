<?php
$title = 'Add Game';
include_once('../header.php');
require_once('../db.php');
require_once('../security.php');
$gameFields = array(
  'primaryName', 'minPlayers', 'maxPlayers',
    'playerAge', 'playingTime', 'maxPlaytime', 'minPlaytime',
    'yearPublished', 'description', 'thumbnail',
    'avgRating', 'avgWeight',
    'numRated', 'numWeighted',
);

$stringFields = array(
  'primaryName', 'description', 'thumbnail'
);

$linkFields = array(
  'mechanics', 'categories', 'subdomains', 'families',
    'publisher', 'designer', 'artist',
);

/*
   INSERT INTO Boardgame () VALUES ();
   INSERT INTO BoardgameMechanics () VALUES ();
   ...
 */

//Wrap string inputs in quotes.
function wrap($key) {
  $v = $_POST[$key];
  $_POST[$key] = "'$v'";
}

if(isset($_POST['primaryName'])) { wrap('primaryName'); }
if(isset($_POST['description'])) { wrap('description'); }
if(isset($_POST['thumbnail'])) { wrap('thumbnail'); }

$fieldNames = array_intersect($gameFields, array_keys($_POST));
$fieldValues = array_values(array_intersect_key($_POST, array_flip($fieldNames)));
$fieldNameString = implode(',',$fieldNames);
$fieldValueString = implode(',',$fieldValues);

$sql = <<<EOQ
START TRANSACTION;
SELECT @nextID := MAX(id) FROM Boardgame;
SET @nextID = @nextID + 1;
INSERT INTO Boardgame (id,$fieldNameString) VALUES (@nextID,$fieldValueString);
EOQ;

//Build link fields
if(isset($_POST['mechanics'])) {
  //loop through mechanics, add SQL statement for each
  $mechs = $_POST['mechanics'];
  foreach($mechs as $mechID) {
    $sql .= "INSERT INTO BoardgameMechanic(mechanicID, gameID) VALUES ($mechID, @nextID);";
  }
}

if(isset($_POST['categories'])) {
  $cats = $_POST['categories'];
  foreach($cats as $catID) {
    $sql .= "INSERT INTO BoardgameCategory(categoryID, gameID) VALUES ($catID, @nextID);";
  }
}

if(isset($_POST['families'])) {
  $fams = $_POST['families'];
  foreach($fams as $famID) {
    $sql .= "INSERT INTO BoardgameFamily(familyID, gameID) VALUES ($famID, @nextID);";
  }
}

if(isset($_POST['subdomains'])) {
  $subs = $_POST['subdomains'];
  foreach($subs as $subID) {
    $sql .= "INSERT INTO BoardgameSubdomain(subdomainID, gameID) VALUES ($subID, @nextID);";
  }
}

if(isset($_POST['publishers'])) {
  $pubs = $_POST['publishers'];
  foreach($pubs as $pubID) {
    $sql .= "INSERT INTO BoardgamePublisher(publisherID, gameID) VALUES ($pubID, @nextID);";
  }
}

if(isset($_POST['designers'])) {
  $designers = $_POST['designers'];
  foreach($designers as $personID) {
    $sql .= "INSERT INTO BoardgameDesigner(personID, gameID) VALUES ($personID, @nextID);";
  }
}

if(isset($_POST['artists'])) {
  $artists = $_POST['artists'];
  foreach($artists as $personID) {
    $sql .= "INSERT INTO BoardgameArtist(personID, gameID) VALUES ($personID, @nextID);";
  }
}

$sql .= "COMMIT;";

//print($sql);

$r = $db->multi_query($sql);
if($db->error) {
  print('<br/>There was an error adding the game');
  print('<br/>');
  print($db->error);
} else {
  print('Game added successfully!');
}
?>


<?php
include_once('../footer.php');
?>
