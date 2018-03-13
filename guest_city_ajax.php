<?php include_once('link.php');?>
<?php
$area = "select * from sys_map_area where smcid='". $_POST["CNo"] ."'";
$area_re = $link->prepare($area);
$area_re->execute();
$area_num = $area_re->rowcount();

if($area_num>0)
{
  echo "<option value=''>請選擇</option>";
  while($area_row=$area_re->fetch())
  {
    echo "<option value='".$area_row['smaid']."'>".$area_row['area']."</option>";
  }
}
else
{
  echo "<option value=''>請選擇</option>";
}
 ?>
