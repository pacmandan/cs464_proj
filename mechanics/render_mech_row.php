<?php

function render_mech_row($data, $db) {
  $id=$data['id'];
  $name=$data['name'];
  $desc=$data['description'];
  
  
  $sql2 =  
  "SELECT b.primaryName, b.thumbnail, b.id FROM
    (BoardgameMechanic bm JOIN Boardgame b ON bm.gameID=b.id)
    WHERE bm.mechanicID = ";
  $sql2 .= $id;
  $sql2 .= " ORDER BY (avgRating*numRated) DESC LIMIT 3;";
  $top3 = $db->query($sql2);
  $i = 0;
  while($topgame = $top3->fetch_assoc()) {
    $bnames[$i]=$topgame['primaryName'];
    $thumbs[$i]=$topgame['thumbnail'];
    $bIDs[$i]=$topgame['id'];
    $i++;
  }

?>
<tr class="mech-row" id="<?=$id?>">
  <td><div class="name"><h2><?=$name?></h2></div>
  </div><br/>
  <div class="description">
    <?=$desc?><br/>
    <em>Popular games with this mechanic:</em><br/>
    <div class="boardgamename"><a href="../boardgame/?id=<?=$bIDs[0]?>"><?=$bnames[0]?></a></div>
    <div class="boardgamename"><a href="../boardgame/?id=<?=$bIDs[1]?>"><?=$bnames[1]?></a></div>
    <div class="boardgamename"><a href="../boardgame/?id=<?=$bIDs[2]?>"><?=$bnames[2]?></a></div>
  </td>
</a></tr>
<?php } ?>
