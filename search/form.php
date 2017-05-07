<?php
$searchFields = array(
  'name', 'playerMin', 'playerMax', 'ageMin', 'ageMax', 'timeMin', 'timeMax',
    'mechanics', 'categories', 'subdomains', 'families',
    'publisher', 'designer', 'artist',
    'ratingMin', 'complexityMin', 'complexityMax'
);
$condFields = array(
  'name', 'playerMin', 'playerMax', 'ageMin', 'ageMax', 'timeMin', 'timeMax',
    'ratingMin', 'complexityMin', 'complexityMax'
);
$joinFields = array(
    'mechanics', 'categories', 'subdomains', 'families',
    'publisher', 'designer', 'artist'
);
function renderForm(& $db, $default) {
  $mechSQL = <<<EOQ
SELECT * FROM Mechanic ORDER BY name ASC;
EOQ;
  $subdomainSQL = <<<EOQ
SELECT * FROM Subdomain ORDER BY name ASC;
EOQ;
  $categorySQL = <<<EOQ
SELECT * FROM Category ORDER BY name ASC;
EOQ;
  $familySQL = <<<EOQ
SELECT * FROM Family ORDER BY name ASC;
EOQ;
  $mechs = $db->query($mechSQL);
  $subdomains = $db->query($subdomainSQL);
  $categories = $db->query($categorySQL);
  $families = $db->query($familySQL);
?>
  <form id="search-form" class="search-form" action="/search">
    <h3>Search for board games</h3>
    Name:<input type="text" name="name" value="<?=$default['name']?>"/><br/>
    <div>
      Players:<input class="num-input" type="text" name="playerMin" value="<?=$default['playerMin']?>"/> -
      <input class="num-input" type="text" name="playerMax" value="<?=$default['playerMax']?>"/>
      Ages: <input class="num-input" type="text" name="ageMin" value="<?=$default['ageMin']?>"/> -
      <input class="num-input" type="text" name="ageMax" value="<?=$default['ageMax']?>"/>
      Playtime: <input class="num-input" type="text" name="timeMin" value="<?=$default['timeMin']?>"/> -
      <input class="num-input" type="text" name="timeMax" value="<?=$default['timeMax']?>"/>
    </div>
    <div>
      <div class="mech-list">
	<label>Mechanics</label>
	<div class="checkbox-list">
	  <ul>
	    <?php
	    while($mech = $mechs->fetch_assoc()) {
	      $name = $mech['name'];
	      $id = $mech['id'];
	      $checked = in_array($id, $default['mechanics']) ? 'checked' : '';
	      print("<li><label><input type='checkbox' name='mechanics[]' value='$id' $checked/>$name</label></li>");
	    }
	    ?>
	  </ul>
	</div>
      </div>
      <div class="types-list">
	<label>Types</label>
	<div class="checkbox-list">
	  <ul>
	    <?php
	    while($sub = $subdomains->fetch_assoc()) {
	      $name = $sub['name'];
	      $id = $sub['id'];
	      $checked = in_array($id, $default['subdomains']) ? 'checked' : '';
	      print("<li><label><input type='checkbox' name='subdomains[]' value='$id' $checked/>$name</label></li>");
	    }
	    ?>
	  </ul>
	</div>
      </div>
      <div class="category-list">
	<label>Categories</label>
	<div class="checkbox-list">
	  <ul>
	    <?php
	    while($cat = $categories->fetch_assoc()) {
	      $name = $cat['name'];
	      $id = $cat['id'];
	      $checked = in_array($id, $default['categories']) ? 'checked' : '';
	      print("<li><label><input type='checkbox' name='categories[]' value='$id' $checked/>$name</label></li>");
	    }
	    ?>
	  </ul>
	</div>
      </div>
      <div class="family-list">
	<label>Families</label>
	<div class="checkbox-list">
	  <ul>
	    <?php
	    while($fam = $families->fetch_assoc()) {
	      $name = $fam['name'];
	      $id = $fam['id'];
	      $checked = in_array($id, $default['families']) ? 'checked' : '';
	      print("<li><label><input type='checkbox' name='subdomains[]' value='$id' $checked/>$name</label></li>");
	    }
	    ?>
	  </ul>
	</div>
      </div>
    </div>
    <div style="clear:both" class="names-inputs">
      <label>Publisher: </label><input type="text" value="<?=$default['publisher']?>" name="publisher"/>
      <label>Designer: </label><input type="text" value="<?=$default['designer']?>" name="designer"/>
      <label>Artist: </label><input type="text" value="<?=$default['artist']?>" name="artist"/>
    </div>
    <div class="ratings-complexity">
      <label>Rating >= </label><input type="text" class="num-input" value="<?=$default['ratingMin']?>" name="ratingMin"/>
      <label>Complexity: </label><input type="text" class="num-input" value="<?=$default['complexityMin']?>" name="complexityMin"/> - <input type="text" class="num-input" value="<?=$default['complexityMax']?>" name="complexityMax"/>
    </div>
    <div class="sort-by">
      <?php
      $sortBy = $default['sortBy'];
      $dir = $default['dir'];
      ?>
      <label>Sort By</label>
      <select name="sortBy">
	<option value="name" <?=$sortBy=='name' ? 'selected' : ''?>>Name</option>
	<option value="owned" <?=$sortBy=='owned' ? 'selected' : ''?>># Own</option>
	<option value="weight" <?=$sortBy=='weight' ? 'selected' : ''?>>Complexity</option>
	<option value="rating" <?=$sortBy=='rating' ? 'selected' : ''?>>Rating</option>
      </select>
      <select name="dir">
	<option value="ASC" <?=$dir=='ASC' ? 'selected' : ''?>>Ascending</option>
	<option value="DESC" <?=$dir=='DESC' ? 'selected' : ''?>>Descending</option>
      </select>
    </div>
    <input type="submit" value="Search"/>
  </form><br/>
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
