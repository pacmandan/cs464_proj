<?php

/* Assume that all input we will ever get is going to end up in the database */

foreach (array_keys ($_GET) as $key) {
  $v = $_GET[$key];
  if(is_array($v)) {
    foreach($v as $akey=>$av) {
      if(!is_numeric($av)) {
	$_GET[$key][$akey] = $db->real_escape_string($av);
      }
    }
  }
  else if (!is_numeric($v)) {
    $_GET[$key] = $db->real_escape_string($v);
  }
}
foreach (array_keys ($_POST) as $key) {
  $v = $_POST[$key];
  if(is_array($v)) {
    foreach($v as $akey=>$av) {
      if(!is_numeric($av)) {
	$_POST[$key][$akey] = $db->real_escape_string($av);
      }
    }
  }
  else if (!is_numeric($v)) {
    $_POST[$key] = $db->real_escape_string($v);
  }
}
?>
