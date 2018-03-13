<?php include_once('link.php');?>
<?php
$sql = "select * from sys_map_city where smcid = '".$_GET['city']."'";
$result = $link->prepare($sql);
$result->execute();
$row = $result->fetch();
 ?>
 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title></title>
   </head>
   <body>
<table align="center" border="1" cellapacing="1">
  <tr align="center">
    <td>自動編號</td>
    <td>語系</td>
    <td>代號</td>
    <td>城市名稱</td>
  </tr>
  <tr>
    <td><?php echo $row['smcid'];?></td>
    <td><?php echo $row['sl_id'];?></td>
    <td><?php echo $row['smsid'];?></td>
    <td><?php echo $row['city'];?></td>
  </tr>
</table>
   </body>
 </html>
