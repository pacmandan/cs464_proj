<?php
$title = 'Find Games';
include_once('../header.php');
require_once('../db.php');
require_once('../security.php');
require_once('form.php');
renderForm($db, $_GET);

if(!empty(array_intersect($searchFields, array_keys($_GET)))) {
  include('render_bg_row.php');
/*
    'name', 'playerMin', 'playerMax', 'ageMin', 'ageMax', 'timeMin', 'timeMax',
    'mechanics', 'categories', 'subdomains', 'families',
    'publisher', 'designer', 'artist',
    'ratingMin', 'complexityMin', 'complexityMax',
    'sortBy', 'dir'*/

  $sql = "SELECT * FROM Boardgame WHERE ";
  $cond = array();
  if(isset($_GET['name'])) {
    $name = $_GET['name'];
    $cond[] = "primaryName LIKE '$name%'";
  }

  if(isset($_GET['playerMin'])) {
    $v = $_GET['playerMin'];
    $cond[] = "minPlayers >= $v";
  }

  if(isset($_GET['playerMax'])) {
    $v = $_GET['playerMax'];
    $cond[] = "maxPlayers <= $v";
  }

  if(isset($_GET['ageMin'])) {
    $v = $_GET['ageMin'];
    $cond[] = "playerAge >= $v";
  }

  if(isset($_GET['ageMax'])) {
    $v = $_GET['ageMax'];
    $cond[] = "playerAge <= $v";
  }

  if(isset($_GET['timeMin'])) {
    $v = $_GET['timeMin'];
    $cond[] = "minPlaytime >= $v";
  }

  if(isset($_GET['timeMax'])) {
    $v = $_GET['timeMax'];
    $cond[] = "maxPlaytime <= $v";
  }


  $condString = implode(' AND ', $cond);
  
  $sql .= $condString.';';
  $r = $db->query($sql);
  print(mysqli_num_rows($r).' Results');
  if(mysqli_num_rows($r) > 0) {
    print('<table class="bg-results-table">');
    while($row = $r->fetch_assoc()) {
      render_bg_row($row);
    }
    print('</table>');
  }
}

require_once('../footer.php');
?>
