<?php
function render_bg_row($data) {
  $id=$data['id'];
  $name=$data['primaryName'];
  $yearPublished = $data['yearPublished'];
  $thumbnail = $data['thumbnail'];
  $minPlayers = $data['minPlayers'];
  $maxPlayers = $data['maxPlayers'];
  $playerAge = $data['playerAge'];
  $playingTime = $data['playingTime'];
  if($data['numWeighted'] == 0) { $weight = '-'; }
  else { $weight = round($data['avgWeight'], 2); }
  if($data['numRated'] == 0) { $rating = '-'; }
  else { $rating = round($data['avgRating'], 2); }
?>
<tr class="bg-row">
  <td class="thumbnail"><a href="/boardgame?id=<?=$id?>"><img src='<?=$thumbnail?>'/></a></td>
  <td><a href="/boardgame?id=<?=$id?>">
    <div class="primary-name"><h2><?=$name?> (<?=$yearPublished?>)</h2></div>
    <div class="ratings">
      <span title='Rating'><i class='fa fa-star' aria-hidden='true'></i> <?=$rating?> / 10</span><br/>
      <span title='Complexity'><i class='fa fa-puzzle-piece' aria-hidden='true'></i> <?=$weight?> / 5</span></div>
  </div><br/>
  <div class="stats">
    <span title="Number of Players"><i class="fa fa-users" aria-hidden="true"></i> <?=$minPlayers?>-<?=$maxPlayers?></span>
    <span title="Game Length"><i class="fa fa-clock-o" aria-hidden="true"></i> <?=$playingTime?> min</span>
    <span title="Age"><i class="fa fa-child" aria-hidden="true"></i> <?=$playerAge?>+ y</span>
  </a>
  </td>
</a></tr>
<?php } ?>
