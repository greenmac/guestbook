<?php include_once('link.php');?>
<?php
$postal="select * from sys_map_area where smaid='".$_POST['TNo']."'";
$postal_re=$link->prepare($postal);
$postal_re->execute();
$postal_num=$postal_re->rowcount();
if($postal_num>0){
  $postal_rows=$postal_re->fetch();
  echo $postal_rows['zip'];
}else{
  echo "無資料";
}
 ?>
