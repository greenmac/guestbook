<?php include_once("../link.php"); ?>
<?php
$g_name = "select g_seq ,g_name ,g_gender ,g_mobile ,g_email ,g_con ,mypostal ,city ,area ,address
         from guest as g1 inner join sys_map_city as s1 on g1.mycity = s1.smcid
                          inner join sys_map_area as s2 on g1.myarea = s2.smaid
                          where g_seq='".$_GET['name']."'";
//$g_name="select * from guest where g_seq='".$_GET['name']."'";
$g_name_rs = $link->prepare($g_name);
$g_name_rs->execute();
$g_name_row = $g_name_rs->fetch();
 ?>
<table align="center" border="1" cellspacing="3">
  <tr align="center">
    <td>暱稱</td>
    <td>性別</td>
    <td>手機</td>
    <td>email</td>
    <td>留言內容</td>
    <td>郵遞區號</td>
    <td>城市</td>
    <td>行政區</td>
    <td>地址</td>
  </tr>
  <tr align="center">
    <td><?php echo $g_name_row['g_name'];?></td>
    <td><?php
    if($g_name_row['g_gender']==1){
      echo $g_name_row['g_gender']="男";
    }elseif($g_name_row['g_gender']==2){
      echo $g_name_row['g_gender']="女";
    };?>
    </td>
    <td><?php echo $g_name_row['g_mobile'];?></td>
    <td><?php echo $g_name_row['g_email'];?></td>
    <td><?php echo $g_name_row['g_con'];?></td>
    <td><?php echo $g_name_row['mypostal'];?></td>
    <td><?php echo $g_name_row['city'];?></td>
    <td><?php echo $g_name_row['area'];?></td>
    <td><?php echo $g_name_row['address'];?></td>
  </tr>
</table>
