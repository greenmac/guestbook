<?php
if(!empty($_SESSION['myname'])){
  $user = $_SESSION['myname'];
}else{
  header('Location:back_login.php');
}

function pre($pre)
{
  echo '<pre>';
  print_r($pre);
  echo '</pre>';
}
 ?>
