<?php include_once("../link.php"); ?>
<?php include_once('back_session.php');?>
<?php
//if(!empty($_GET['up'])){
//$up = $_GET['up'];
//$sql2 = "select * from guest where g_seq='$up'";
$sql2 = "select *
         from guest as g1
         inner join sys_map_city as s1
         on g1.mycity = s1.smcid
         inner join sys_map_area as s2
         on g1.myarea = s2.smaid
         where g_seq='".$_GET['up']."'";
$re2 = $link->prepare($sql2);
$re2->execute();
$row2 = $re2->fetch();
$smcid=$row2['smcid'];
// pre($smcid);
//}
$sql3 = "select * from sys_map_city where smsid = 1";
$re3 = $link->prepare($sql3);
$re3->execute();
$row3 = $re3->fetch();
// pre($row3);

$sql4 ="select * from sys_map_area where smcid=$smcid";
$re4 = $link->prepare($sql4);
$re4->execute();
$row4 = $re4->fetchall();
// pre($row4);

if(!empty($_POST['mm_update'])){
$update = $_POST['update'];

$g_name = $_POST['g_name'];
$g_ra = $_POST['g_ra'];
$g_mobile = $_POST['g_mobile'];
$g_email = $_POST['g_email'];
$g_con = $_POST['g_con'];
$mypostal = $_POST['mypostal'];

$mycity = $_POST['mycity'];
$myarea = $_POST['myarea'];
$address = $_POST['address'];

$sql1 = $link->exec("update
guest as g1
inner join sys_map_city as s1 on g1.mycity = s1.smcid
inner join sys_map_area as s2 on g1.myarea = s2.smaid
set g_name='$g_name' ,g_gender='$g_ra' ,g_mobile='$g_mobile' ,g_email='$g_email' ,g_con='$g_con' ,mypostal='$mypostal' ,mycity='$mycity' ,myarea='$myarea' ,address='$address' where g_seq='$update'");
$re1 = $link->prepare($sql1);
$re1->execute();
$row1 = $re1->fetch();

header("Location:back_admin.php?");
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
  </head>
  <form class="" action="back_update.php" method="post" name="f1" id="f1">
    <body>
    <table align="center" border="1" cellspacing="0">
      <tr align="center" bgcolor="#33CCFF">
        <td>暱稱</td>
        <td>性別</td>
        <td>手機</td>
        <td>email</td>
        <td>留言內容</td>
      </tr>
      <tr align="center">
        <td><input name="g_name" id="g_name" type="text" value="<?php echo $row2['g_name'];?>"></td>
        <td>男<input name="g_ra" id="g_ra" type="radio" value="1">
            女<input name="g_ra" id="g_ra" type="radio" value="2">
        </td>
        <td><input name="g_mobile" id="g_mobile" type="text" value="<?php echo $row2['g_mobile'];?>"></td>
        <td><input name="g_email" id="g_email" type="text" value="<?php echo $row2['g_email'];?>"></td>
        <td><input name="g_con" id="g_con" type="text" value="<?php echo $row2['g_con'];?>"></td>
      </tr>
      <tr align="center" bgcolor="#33CCFF">
        <td>郵遞區號</td>
        <td>城市</td>
        <td>行政區</td>
        <td>地址</td>
        <td>操作</td>
      </tr>
      <tr align="center">
        <td><input name="mypostal" id="mypostal" type="text" value="<?php echo $row2['mypostal'];?>" readonly></td>
        <td>
          <select class="" name="mycity" id="mycity">
            <?php do{;?>
            <?php $chk=$row2['mycity']==$row3['smcid']?'selected':'';?>
            <option value="<?php echo $row3['smcid'];?>"<?php echo $chk;?>><?php echo $row3['city'];?></option>
          <?php }while($row3 = $re3->fetch());?>
          </select>
        </td>
        <td>
          <select class="" name="myarea" id="myarea">
            <?php
              foreach($row4 as $row4)
              {
                $chk=$row2['myarea']==$row4['smaid']?'selected':'';
                echo '<option value="'.$row4['smaid'].'"'.$chk.'>'.$row4['area'].'</option>';
              }
            ?>
          </select>
        </td>
        <td><input name="address" id="address" type="text" value="<?php echo $row2['address'];?>"></td>
        <td><input name="sent" id="sent" value="送出" type="submit"></td>
      </tr>
    </table>
      <input type="hidden" name="update" id="update" value="<?php echo $row2['g_seq'];?>">
      <input type="hidden" name="mm_update" value="f1">
    </form>
    <script>
    $("input[name=g_ra][value=<?php echo $row2['g_gender'];?>]").prop("checked",true);
    $(document).ready(function(){
              //利用jQuery的ajax把縣市編號(CNo)傳到Town_ajax.php把相對應的區域名稱回傳後印到選擇區域(鄉鎮)下拉選單
              $('#mycity').change(function(){
                  var CNo= $('#mycity').val();
                  $.ajax({
                      type: "POST",
                      url: 'back_city_ajax.php',
                      cache: false,
                      data:'CNo='+CNo,
                      error: function(){
                          alert('Ajax request 發生錯誤');
                      },
                      success: function(data){
                          $('#myarea').html(data);
                          //$('#asdf').html(data);
                          $('#mypostal').val("");//避免重新選擇縣市後郵遞區號還存在，所以在重新選擇縣市後郵遞區號欄位清空
                      }
                  });

              });
              //根據選擇區域(鄉鎮)的編號傳到Zip_ajax.php把區域對應的郵遞區號印到指定的郵遞區號欄位

              $('#myarea').change(function(){
                      var TNo= $('#myarea').val();
                      //alert(TNo);

                      $.ajax({
                          type: "POST",
                          url: 'back_area_ajax.php',
                          cache: false,
                          data:'TNo='+TNo,
                          error: function(){
                              alert('Ajax request 發生錯誤');
                          },
                          success: function(data){
                              $('#mypostal').val(data);
                          }
                  });

              });

          });
    </script>
    </body>
</html>
