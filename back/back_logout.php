<?php include_once('../link.php');?>
<?php include_once('back_session.php');?>
<?php
  $_SESSION['myname'] = NULL;
  unset($_SESSION['myname']);
  header('Location:back_login.php');
 ?>
