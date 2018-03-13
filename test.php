<?php
module -> auth->


include(function.php);

function delete(){
  delete...
}

function update(){
  update...
}

$act=$_POST["act"];

if()

switch($act)
{
  case 'delete':
      delete();
      do delete;
    break;
  case 'update':
      update();
      do update;
    break;
}


?>

<?php?>
<?php include_once('link.php');?>
<?php
$sql = "select * from sys_map_city";
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
    <table>
      <?php do{;?>
      <tr>
        <td><a href="test_colorbox.php?city=<?php echo $row['smcid'];?>"><?php echo $row['city'];?></td>
      </tr>
    <?php }while($row = $result->fetch());?>
    </table>
  </body>
</html>
