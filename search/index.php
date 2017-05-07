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

  $sql = "SELECT * FROM Boardgame ";
  $cond = array();

  if(isset($_GET['mechanics'])) {
    $mechs = $_GET['mechanics'];
    $idString = implode(',', $mechs);
    $sql .= "JOIN (SELECT DISTINCT gameID FROM BoardgameMechanic WHERE mechanicID IN ($idString)) m ON Boardgame.id=m.gameID ";
  }
  
  if(isset($_GET['categories'])) {
    $cats = $_GET['categories'];
    $idString = implode(',', $cats);
    $sql .= "JOIN (SELECT DISTINCT gameID FROM BoardgameCategory WHERE categoryID IN ($idString)) c ON Boardgame.id=c.gameID ";
  }

  if(isset($_GET['families'])) {
    $fams = $_GET['families'];
    $idString = implode(',', $fams);
    $sql .= "JOIN (SELECT DISTINCT gameID FROM BoardgameFamily WHERE familyID IN ($idString)) f ON Boardgame.id=f.gameID ";
  }

  if(isset($_GET['subdomains'])) {
    $subs = $_GET['subdomains'];
    $idString = implode(',', $subs);
    $sql .= "JOIN (SELECT DISTINCT gameID FROM BoardgameSubdomain WHERE subdomainID IN ($idString)) s ON Boardgame.id=s.gameID ";
  }

  if(isset($_GET['publisher'])) {
    $v = $_GET['publisher'];
    $sql .= "JOIN (SELECT gameID FROM Publisher JOIN BoardgamePublisher bp ON bp.publisherID=Publisher.id WHERE name LIKE '$v%') p ON Boardgame.id=p.gameID ";
  }
  
  if(isset($_GET['designer'])) {
    $v = $_GET['designer'];
    $sql .= "JOIN (SELECT gameID FROM Person JOIN BoardgameDesigner bd ON bd.personID=Person.id WHERE name LIKE '$v%') d ON Boardgame.id=d.gameID ";
  }

  if(isset($_GET['artist'])) {
    $v = $_GET['artist'];
    $sql .= "JOIN (SELECT gameID FROM Person JOIN BoardgameArtist ba ON ba.personID=Person.id WHERE name LIKE '$v%') a ON Boardgame.id=a.gameID ";
  }

  //All fields that come after "WHERE"
  if(!empty(array_intersect($condFields, array_keys($_GET)))) {
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

    if(isset($_GET['ratingMin'])) {
      $v = $_GET['ratingMin'];
      $cond[] = "avgRating >= $v";
    }

    if(isset($_GET['complexityMin'])) {
      $v = $_GET['complexityMin'];
      $cond[] = "avgWeight >= $v";
    }

    if(isset($_GET['complexityMax'])) {
      $v = $_GET['complexityMax'];
      $cond[] = "avgWeight <= $v";
    }

    $sql .= "WHERE ";
    $condString = implode(' AND ', $cond);
    $sql .= $condString;
  }

  if(isset($_GET['sortBy'])) {
    switch($_GET['sortBy']) {
      case 'owned':
	$sql .= " ORDER BY numOwn";
	break;
      case 'weight':
	$sql .= " ORDER BY avgWeight";
	break;
      case 'rating':
	$sql .= " ORDER BY avgRating";
	break;
      case 'name':
      default:
	$sql .= " ORDER BY primaryName";
	break;

    }
    if(isset($_GET['dir'])) {
      if($_GET['dir'] == "ASC") { $sql .= " ASC"; }
      else if($_GET['dir'] == "DESC") { $sql .= " DESC"; }
    }
  }
  $sql .= ";";
  //print($sql);
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
