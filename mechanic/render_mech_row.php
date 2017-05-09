<?php
function render_mech_row($data) {
  $id=$data['id'];
  $name=$data['name'];
  $desc=$data['description'];
?>
<tr class="mech-row">
  <td><a href="/mechanic?id=<?=$id?>">
    <div class="name"><h2><?=$name?></h2></div>
  </div></a><br/>
  <div class="description">
    <span title="Description"><?=$desc?></span>
  </td>
</a></tr>
<?php } ?>
