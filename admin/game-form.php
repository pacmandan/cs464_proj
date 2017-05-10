<?php
function renderForm($db, $defaults, $type) {
  require('../search/render_checkbox_list.php');

  //$mechSQL = "SELECT * FROM Mechanic ORDER BY name ASC;";
  //$subdomainSQL = "SELECT * FROM Subdomain ORDER BY name ASC;";
  //$categorySQL = "SELECT * FROM Category ORDER BY name ASC;";
  //$familySQL = "SELECT * FROM Family ORDER BY name ASC;";
  //$publisherSQL = "SELECT * FROM Publisher ORDER BY name ASC;";
  //$personSQL = "SELECT * FROM Person ORDER BY name ASC;";
  
  //$mechs = $db->query($mechSQL);
  //$subdomains = $db->query($subdomainSQL);
  //$categories = $db->query($categorySQL);
  //$families = $db->query($familySQL);
  //$publishers = $db->query($publisherSQL);
  //$artists = $db->query($personSQL);
  //$designers = $db->query($personSQL);

  $link = $type == 'Add' ? '/admin/add-game.php' : '/admin/edit-game.php';
?>
  <h2><?=$type?> Boardgame</h2>
  <form id="search-form" action="<?=$link?>" method="post">
    <?php
    if(isset($defaults['id']) && $type!='Add') {
      $id = $defaults['id'];
      print("<input type='hidden' name='id' value='$id' />");
    }
    ?>
    <label>Name</label><input type="text" name="primaryName" value="<?=$defaults['primaryName']?>"/><br/>
    Thumbnail Link: <input type="text"  name="thumbnail" value="<?=$defaults['thumbnail']?>"/><br/>
    Players:<input class="num-input" type="text" name="minPlayers" value="<?=$defaults['minPlayers']?>"/> -
    <input class="num-input" type="text" name="maxPlayers" value="<?=$defaults['maxPlayers']?>"/><br/>
    Age: <input class="num-input" type="text" name="playerAge" value="<?=$defaults['playerAge']?>"/><br/>
    Playtime: <input class="num-input" type="text" name="minPlaytime" value="<?=$defaults['minPlaytime']?>"/> -
    <input class="num-input" type="text" name="maxPlaytime" value="<?=$defaults['maxPlaytime']?>"/><br/>
    Year Published: <input type="text" name="yearPublished" value="<?=$defaults['yearPublished']?>"/><br/>
    Description:<br/><textarea name="description"><?=$defaults['description']?></textarea><br/>
    Mechanics: <input type="text" name="mechanics" value="<?=$defaults['mechanics']?>"/><br/>
    Types: <input type="text" name="subdomains" value="<?=$defaults['subdomains']?>"/><br/>
    Categories: <input type="text" name="categories" value="<?=$defaults['categories']?>"/><br/>
    Families: <input type="text" name="families" value="<?=$defaults['families']?>"/><br/>
    Publishers: <input type="text" name="publishers" value="<?=$defaults['publishers']?>"/><br/>
    Artists: <input type="text" name="artists" value="<?=$defaults['artists']?>"/><br/>
    Designers: <input type="text" name="designers" value="<?=$defaults['designers']?>"/><br/>
    Expansions: <input type="text" name="expansions" value="<?=$defaults['expansions']?>"/><br/>
    Bases: <input type="text" name="bases" value="<?=$defaults['bases']?>"/><br/>
    Implementations: <input type="text" name="implementations" value="<?=$defaults['implementations']?>"/><br/>
    Originals: <input type="text" name="originals" value="<?=$defaults['originals']?>"/><br/>
    <input type="submit" value="<?=$type?> Game"/>
  </form>
  <script language="javascript">
  //Prevent the form from submitting empty fields
  $('#search-form').submit(function () {
    $(this)
      .find('input[name]')
      .filter(function () {
        return !this.value;
      })
      .prop('name', '');
  });
  </script>

<?php
}
?>
