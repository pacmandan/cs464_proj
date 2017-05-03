<?php
function render_bg_row($data) {
	print('<tr class="bg-row">');
	//print('<td>');print_r($data);print('</td>');
	$name=$data['primaryName'];
	$thumbnail = $data['thumbnail'];
	$minPlayers = $data['minPlayers'];
	$maxPlayers = $data['maxPlayers'];
	$playerAge = $data['playerAge'];
	$playingTime = $data['playingTime'];
	$desc = $data['description'];
	if($data['numWeighted'] == 0) { $weight = '-'; }
	else { $weight = round($data['avgWeight'], 2); }
	if($data['numRated'] == 0) { $rating = '-'; }
	else { $rating = round($data['avgRating'], 2); }
	print("<td><img src='$thumbnail'/></td>"
		  .'<td>'
		  .'<div>'
		  ."<h2 class='primary-name'>$name</h2>"
		  .'<div class="ratings">'
		  ."<p title='Rating'><i class='fa fa-star' aria-hidden='true'></i>&nbsp;$rating / 10</p>"
		  ."<p title='Complexity'><i class='fa fa-puzzle-piece' aria-hidden='true'></i>&nbsp;$weight / 5</p></div>"
		  .'</div>'
		  .'</td></tr>');
}
?>