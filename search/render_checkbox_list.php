<?php
function render_checkbox_list($title, $groupName, $items, $defaults) {
?>
  <div>
    <label><?=$title?></label>
    <div class="checkbox-list">
      <ul>
	<?php
	while($item = $items->fetch_assoc()) {
	  $name = $item['name'];
	  $id = $item['id'];
	  $checked = in_array($id, $defaults) ? 'checked' : '';
	  print("<li><label><input type='checkbox' name='$groupName[]' value='$id' $checked/>$name</label></li>");
	}
	?>
      </ul>
    </div>
  </div>
<?php
}
?>
