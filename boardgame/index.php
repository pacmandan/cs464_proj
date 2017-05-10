<?php
require_once('../db.php');
require_once('../security.php');

if(!isset($_GET['id'])) {
  $title = 'No ID';
  include('../header.php');
  print('<h1>No boardgame selected</h1><br/><a href="/">Back to main</a>');
} else {
  $id = $_GET['id'];
  $setGroupSQL = 'SET group_concat_max_len = 2048;';
  $resetGroupSQL = 'SET group_concat_max_len = 1024;';
  $sql = <<<EOQ
SELECT * FROM
(SELECT * FROM Boardgame WHERE id=$id) AS b

LEFT JOIN (SELECT gameID, GROUP_CONCAT(DISTINCT CONCAT(id,',',name) SEPARATOR ';') AS mechanics FROM BoardgameMechanic bm JOIN Mechanic m ON m.id=bm.mechanicID WHERE bm.gameID=$id) AS mech ON b.id=mech.gameID

LEFT JOIN (SELECT gameID, GROUP_CONCAT(DISTINCT CONCAT(id,',',name) SEPARATOR ';') AS categories FROM BoardgameCategory bc JOIN Category c ON c.id=bc.categoryID WHERE bc.gameID=$id) AS cat ON b.id=cat.gameID

LEFT JOIN (SELECT gameID, GROUP_CONCAT(DISTINCT CONCAT(id,',',name) SEPARATOR ';') AS families FROM BoardgameFamily bf JOIN Family f ON f.id=bf.familyID WHERE bf.gameID=$id) AS fam ON b.id=fam.gameID

LEFT JOIN (SELECT gameID, GROUP_CONCAT(DISTINCT CONCAT(id,',',name) SEPARATOR ';') AS subdomains FROM BoardgameSubdomain bs JOIN Subdomain s ON s.id=bs.subdomainID WHERE bs.gameID=$id) AS sub ON b.id=sub.gameID

LEFT JOIN (SELECT gameID, GROUP_CONCAT(DISTINCT CONCAT(id,',',name) SEPARATOR ';') AS designers FROM BoardgameDesigner bd JOIN Person d ON d.id=bd.personID WHERE bd.gameID=$id) AS des ON b.id=des.gameID

LEFT JOIN (SELECT gameID, GROUP_CONCAT(DISTINCT CONCAT(id,',',name) SEPARATOR ';') AS artists FROM BoardgameArtist ba JOIN Person a ON a.id=ba.personID WHERE ba.gameID=$id) AS art ON b.id=art.gameID

LEFT JOIN (SELECT baseID AS gameID, GROUP_CONCAT(DISTINCT CONCAT(exp.primaryName,',',expansionID) SEPARATOR ';') AS expansions FROM BoardgameExpansion be JOIN Boardgame exp ON exp.id=be.expansionID WHERE baseID=$id) AS exp ON b.id=exp.gameID

LEFT JOIN (SELECT expansionID AS gameID, GROUP_CONCAT(DISTINCT CONCAT(base.primaryName,',',baseID) SEPARATOR ';') AS bases FROM BoardgameExpansion be JOIN Boardgame base ON base.id=be.baseID WHERE expansionID=$id) AS base ON b.id=base.gameID

LEFT JOIN (SELECT implementationID as gameID, GROUP_CONCAT(DISTINCT CONCAT(original.primaryName,',',originalID) SEPARATOR ';') AS originals FROM BoardgameImplementation bi JOIN Boardgame original ON original.id=bi.originalID WHERE implementationID=$id) AS orig ON b.id=orig.gameID

LEFT JOIN (SELECT originalID as gameID, GROUP_CONCAT(DISTINCT CONCAT(impl.primaryName,',',implementationID) SEPARATOR ';') AS implementations FROM BoardgameImplementation bi JOIN Boardgame impl ON impl.id=bi.implementationID WHERE originalID=$id) AS impl ON b.id=impl.gameID

LEFT JOIN (SELECT gameID, GROUP_CONCAT(DISTINCT CONCAT(id,',',name) SEPARATOR ';') AS publishers FROM BoardgamePublisher bp JOIN Publisher p ON p.id=bp.publisherID WHERE bp.gameID=$id) AS pub ON b.id=pub.gameID

LEFT JOIN (SELECT $id AS gameID, COUNT(DISTINCT gii.geeklistID) AS numGeeklists FROM GeeklistItemHasBoardgame gihb JOIN GeeklistItemIn gii ON gii.itemID=gihb.itemID WHERE gihb.gameID=$id) AS geeklists ON b.id=geeklists.gameID;
EOQ;
  $db->query($setGroupSQL);
  $r = $db->query($sql);
  $db->query($resetGroupSQL);
  if(mysqli_num_rows($r) == 0) {
    $title = 'Invalid ID';
    include('../header.php');
    print("Game with ID of $id does not exist");
  } else {
    $game = $r->fetch_assoc();

    $primaryName = $game['primaryName'];
    $thumbnail = $game['thumbnail'];
    $minPlayers = $game['minPlayers'];
    $maxPlayers = $game['maxPlayers'];
    $playerAge = $game['playerAge'];
    $playingTime = $game['playingTime'];
    $numOwn = $game['numOwn'];
    $numTrading = $game['numTrading'];
    $numWishlist = $game['numWishlist'];
    $numGeeklists = $game['numGeeklists'];
    $mechanics = $game['mechanics'];
    $categories = $game['categories'];
    $subdomains = $game['subdomains'];
    $families = $game['families'];
    $publishers = $game['publishers'];
    $artists = $game['artists'];
    $designers = $game['designers'];
    $description = $game['description'];
    $bases = $game['bases'];
    $expansions = $game['expansions'];
    $originals = $game['originals'];
    $implementations = $game['implementations'];
    if($game['numWeighted'] == 0) { $weight = '-'; }
    else { $weight = round($game['avgWeight'], 2); }
    if($game['numRated'] == 0) { $rating = '-'; }
    else { $rating = round($game['avgRating'], 2); }

    
    //Render header
    //$title = $game['primaryName'];
    include('../header.php');
    //print_r($game);
?>
  <br/>
  <img class="bg-thumbnail" src="<?=$thumbnail?>"/>
  <div class="bg-detail">
    <h1><?=$primaryName?></h1>
    <div class="user-stats">
      <span><strong>Owned by <?=$numOwn?> users</strong></span>
      <span><strong>Traded by <?=$numTrading?> users</strong></span>
      <span><strong>Wishlisted by <?=$numWishlist?> users</strong></span>
      <span><strong>In <?=$numGeeklists?> Geeklists</strong></span>
    </div>
    <div class="game-stats">
      <span title='Rating'><i class='fa fa-star' aria-hidden='true'></i> <?=$rating?> / 10</span>
      <span title='Complexity'><i class='fa fa-puzzle-piece' aria-hidden='true'></i> <?=$weight?> / 5</span>
      <span title="Number of Players"><i class="fa fa-users" aria-hidden="true"></i> <?=$minPlayers?>-<?=$maxPlayers?></span>
      <span title="Game Length"><i class="fa fa-clock-o" aria-hidden="true"></i> <?=$playingTime?> min</span>
      <span title="Age"><i class="fa fa-child" aria-hidden="true"></i> <?=$playerAge?>+ y</span>
    </div>
    <br/>
    <div class="collections">
      <div class="subdomains">
	<h3>Type</h3>
	<?php
	foreach (explode(';', $subdomains) as $subdomain) {
	  $s = explode(',', $subdomain);
	  print("<span href='/family?id=$s[0]'>$s[1]</span>");
	}
	?>
      </div>
      <div class="mechanics">
	<h3>Mechanics</h3>
	<?php
	foreach (explode(';', $mechanics) as $mechanic) {
	  $m = explode(',', $mechanic);
	  print("<a href='/mechanics#$m[0]'>$m[1]</a>");
	}
	?>
      </div>
      <div class="families">
	<h3>Families</h3>
	<?php
	foreach (explode(';', $families) as $family) {
	  $f = explode(',', $family);
	  print("<span href='/family?id=$f[0]'>$f[1]</span>");
	}
	?>
      </div>
      <div class="categories">
	<h3>Categories</h3>
	<?php
	foreach (explode(';', $categories) as $category) {
	  $c = explode(',', $category);
	  print("<span href='/category?id=$c[0]'>$c[1]</span>");
	}
	?>
      </div>
    </div>
    <div class="description">
      <p><?=$description?></p>
    </div>
    <div class="people">
      <div class="publishers">
	<h3>Publishers</h3>
	<?php
	foreach (explode(';', $publishers) as $publisher) {
	  $p = explode(',', $publisher);
	  print("<span href='/publisher?id=$p[0]'>$p[1]</span>");
	}
	?>
      </div>
      <div class="designers">
	<h3>Designers</h3>
	<?php
	foreach (explode(';', $designers) as $designer) {
	  $d = explode(',', $designer);
	  print("<span href='/designer?id=$d[0]'>$d[1]</span>");
	}
	?>
      </div>
      <div class="artists">
	<h3>Artists</h3>
	<?php
	foreach (explode(';', $artists) as $artist) {
	  $a = explode(',', $artist);
	  print("<span href='/designer?id=$a[0]'>$a[1]</span>");
	}
	?>
      </div>
    </div>
    <div class="other-games">
      <?php
      if(count($expansions) > 0) {
	print('<div class="expansions"><h3>Expansions</h3>');
	foreach(explode(';', $expansions) as $expansion) {
	  $exp = explode(',', $expansion);
	  print("<a href='/boardgame?id=$exp[1]'>$exp[0]</a>");
	}
	print('</div>');
      }
      if(count($bases) > 0) {
	print('<div class="bases"><h3>Base Game</h3>');
	foreach(explode(';', $bases) as $base) {
	  $b = explode(',',$base);
	  print("<a href='/boardgame?id=$b[1]'>$b[0]</a>");
	}
	print('</div>');
      }
      if(count($implementations) > 0) {
	print('<div class="implementations"><h3>Implementations</h3>');
	foreach(explode(';', $implementations) as $implementation) {
	  $i = explode(',',$implementation);
	  print("<a href='/boardgame?id=$i[1]'>$i[0]</a>");
	}
	print('</div>');
      }
      if(count($originals) > 0) {
	print('<div class="originals"><h3>Originals</h3>');
	foreach(explode(';', $originals) as $orig) {
	  $o = explode(',',$orig);
	  print("<a href='/boardgame?id=$o[1]'>$o[0]</a>");
	}
	print('</div>');
      }
      ?>
    </div>
  </div>
  
<?php
  }
}
include('../footer.php');
?>
