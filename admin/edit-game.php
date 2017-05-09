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
    'numRated', 'numWeighted',
);
$stringFields = array(
  'primaryName', 'description', 'thumbnail'
);

$fieldNames = array_intersect($gameFields, array_keys($_POST));
$fields = array_intersect_key($_POST, array_flip($fieldNames));
$id = $_POST['id'];

$sql = "UPDATE Boardgame SET ";
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

$db->query($sql);
if($db->error) {
  print('<br/>There was an error updating the game!');
  print('<br/>');
  print($db->error);
} else {
  print('Games updated successfully!');
}

include_once('../footer.php');
?>
