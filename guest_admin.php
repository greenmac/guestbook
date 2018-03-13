<?php include_once('link.php');?>
<?php include_once('guest_session.php');?>
<?php
if((!empty($_POST['g_name'])) && (!empty($_POST['g_ra'])) && (!empty($_POST['g_mobile'])) && (!empty($_POST['g_email'])))
  {
    $_SESSION['g_name'] = $_POST['g_name'];
    $_SESSION['g_ra'] = $_POST['g_ra'];
    $_SESSION['g_mobile'] = $_POST['g_mobile'];
    $_SESSION['g_email'] = $_POST['g_email'];
    $_SESSION['mycity'] = $_POST['mycity'];
    $_SESSION['myarea'] = $_POST['myarea'];
    $_SESSION['address'] = $_POST['address'];
    $_SESSION['mypostal'] = $_POST['mypostal'];
echo $_SESSION['g_ra'];
  }
//print_r($_POST);

if(!empty($_POST['g_con']))
  {
    $g_name = $_SESSION['g_name'];
    $g_ra = $_SESSION['g_ra'];
    $g_con = $_POST['g_con'];
    $g_mobile = $_SESSION['g_mobile'];
    $g_email = $_SESSION['g_email'];
    $mypostal = $_SESSION['mypostal'];
    $mycity = $_SESSION['mycity'];
    $myarea = $_SESSION['myarea'];
    $address = $_SESSION['address'];

    $sql1 =$link->exec("insert into guest(g_name ,g_gender ,g_mobile ,g_email ,g_con ,mypostal ,mycity ,myarea ,address) values ('$g_name' ,'$g_ra' ,'$g_mobile' ,'$g_email' ,'$g_con' ,'$mypostal' ,'$mycity' ,'$myarea' ,'$address')");
    $re1 = $link->prepare($sql1);
    $re1->execute();

    header("Location:guest_admin.php");
  }

$sql2 = "select * from guest order by g_seq desc";
$re2 = $link->prepare($sql2);
$re2->execute();
$row2 = $re2->fetchall(PDO::FETCH_ASSOC);
$nums = $re2->rowcount();
//echo '<pre>';
//print_r($row2);
//echo '</pre>';

$per = 5;
$pages = ceil($nums/$per);
if(!isset($_GET['page']))
  {
    $page = 1;
  }
  else
  {
    $page = (int)$_GET['page'];
  }
$start = ($page-1)*$per;
$sql2.= " LIMIT $start,$per";
$re2 = $link->prepare($sql2);
$re2->execute();
$row2 = $re2->fetchall();

 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <table align="center" border="1" cellspacing="0">
      <tr align="center">
        <td  colspan="2"><a href="guest_logout.php">離開使用者</a></td>
      </tr>
      <tr align="center">
        <td align="left">暱稱:</td>
        <td><?php echo $_SESSION['g_name'];?></td>
      </tr>
      <tr align="center">
        <td align="left">性別:</td>
        <td><?php if($_SESSION['g_ra'] == 1){
          echo $_SESSION['g_ra'] = "男";
          $_SESSION['g_ra'] = 1;
        }elseif($_SESSION['g_ra'] == 2){
          echo $_SESSION['g_ra'] = "女";
          $_SESSION['g_ra'] = 2;
        };?></td>
      </tr>
      <tr align="center">
        <td align="left">手機:</td>
        <td><?php echo $_SESSION['g_mobile'];?></td>
      </tr>
      <tr align="center">
        <td align="left">email:</td>
        <td><?php echo $_SESSION['g_email'];?></td>
      </tr>

      <form action="guest_admin.php" method="post">
      <table align="center">
        <tr align="center">
          <td>留言內容</td>
          <td><input type="text" name="g_con" id="g_con"/></td>
          <td><input type="submit" value="新增"/></td>
        </tr>
      </table>
    </form>
    </table>
    <p align="center">--------------------------------------------------------------------------</p>
    <table align="center" border="1" cellspacing="0">
      <tr align="center">
        <td>暱稱</td>
        <td>性別</td>
        <td>手機</td>
        <td>email</td>
        <td>留言內容</td>
      </tr>
    <?php foreach($row2 as $row2){?>
      <tr align="center">
        <td><?php echo $row2['g_name'];?></td>
        <td><?php
        if($row2['g_gender']==1){
          echo $row2['g_gender']="男";
        }elseif($row2['g_gender']==2){
          echo $row2['g_gender']="女";
        }
        ;?></td>
        <td><?php echo $row2['g_mobile'];?></td>
        <td><?php echo $row2['g_email'];?></td>
        <td><?php echo $row2['g_con'];?></td>
      </tr>
    <?php }?>
    </table>
    <p align="center">
    <?php
     echo "<a href=?page=1>首頁</a>"."　";
     for($i=1;$i<=$pages;$i++)
     {
       if($i == $page)
      {
        echo '<font size="10">'.$i.'</font>'."　";
      }
      else
      {
        echo '<a href="?page='.$i.'">'.$i.'</a>'."　";
      }
    }
    echo "　"."<a href=?page=".$pages.">末頁</a>";
     ?>
   </p>
  </body>

</html>
