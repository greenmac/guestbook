<?php include_once('../link.php')?>
<?php include_once('back_session.php');?>
<?php
if(isset($_GET['del'])){
  $del = $_GET['del'];
  $sql1 = $link->exec("delete from guest where g_seq='$del'");
  $re1 = $link->prepare($sql1);
  $re1->execute();
  $row1= $re1->fetch($re1);

  header("Location:back_admin.php");
}
 ?>
