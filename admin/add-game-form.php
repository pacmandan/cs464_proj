<?php
function renderForm($db, $defaults, $type) {
  require('../search/render_checkbox_list.php');

  $mechSQL = "SELECT * FROM Mechanic ORDER BY name ASC;";
  $subdomainSQL = "SELECT * FROM Subdomain ORDER BY name ASC;";
  $categorySQL = "SELECT * FROM Category ORDER BY name ASC;";
  $familySQL = "SELECT * FROM Family ORDER BY name ASC;";
  $publisherSQL = "SELECT * FROM Publisher ORDER BY name ASC;";
  $personSQL = "SELECT * FROM Person ORDER BY name ASC;";
  
  $mechs = $db->query($mechSQL);
  $subdomains = $db->query($subdomainSQL);
  $categories = $db->query($categorySQL);
  $families = $db->query($familySQL);
  $publishers = $db->query($publisherSQL);
  $artists = $db->query($personSQL);
  $designers = $db->query($personSQL);

  $link = $type == 'Add' ? '/admin/add-game.php' : '/admin/edit-game.php';
  
?>
  <h1><?=$type?> Boardgame</h1>
  <form action="<?=$link?>" method="post">
    <label>Name</label><input type="text" name="primaryName" value="<?=$defaults['primaryName']?>"/><br/>
    Thumbnail Link: <input type="text"  name="thumbnail" value="<?=$defaults['thumbnail']?>"/><br/>
    Players:<input class="num-input" type="text" name="minPlayers" value="<?=$defaults['minPlayers']?>"/> -
    <input class="num-input" type="text" name="maxPlayers" value="<?=$defaults['maxPlayers']?>"/><br/>
    Age: <input class="num-input" type="text" name="playerAge" value="<?=$defaults['playerAge']?>"/><br/>
    Playtime: <input class="num-input" type="text" name="minPlaytime" value="<?=$defaults['minPlaytime']?>"/> -
    <input class="num-input" type="text" name="maxPlaytime" value="<?=$defaults['maxPlaytime']?>"/><br/>
    Year Published: <input type="text" name="yearPublished" value="<?=$defaults['yearPublished']?>"/><br/>
    
    <?php
    render_checkbox_list("Mechanics", $mechs, isset($defaults['mechanics']) ? $defaults['mechanics'] : array());
    render_checkbox_list("Types", $subdomains, isset($defaults['subdomains']) ? $defaults['subdomains'] : array());
    render_checkbox_list("Categories", $categories, isset($defaults['categories']) ? $defaults['categories'] : array());
    render_checkbox_list("Families", $families, isset($defaults['families']) ? $defaults['families'] : array());
    render_checkbox_list("Publishers", $publishers, isset($defaults['publishers']) ? $defaults['publishers'] : array());
    render_checkbox_list("Artists", $artists, isset($defaults['artists']) ? $defaults['artists'] : array());
    render_checkbox_list("Designers", $designers, isset($defaults['designers']) ? $defaults['designers'] : array());
    ?>
    <input type="submit" value="Add Game"/>
  </form>
<?php
}
?>
