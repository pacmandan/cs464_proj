<?php
function render_bg_row($data) {
	print('<tr>');
	//print('<td>');print_r($data);print('</td>');
	$name=$data['primaryName'];
	$thumbnail = $data['thumbnail'];
	$minPlayers = $data['minPlayers'];
	$maxPlayers = $data['maxPlayers'];
	$playerAge = $data['playerAge'];
	$playingTime = $data['playingTime'];
	$desc = $data['description'];
	$weight = $data['avgWeight'];
	$rating = $data['avgRating'];
	print("<td><img src='$thumbnail'/></td>"
		  .'<td>'
		  ."<h2>$name</h2>"
		  .'</td></tr>');
}
?>