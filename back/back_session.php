<?php
if(!empty($_SESSION['myname'])){
  $user = $_SESSION['myname'];
}else{
  header('Location:back_login.php');
}
 ?>
