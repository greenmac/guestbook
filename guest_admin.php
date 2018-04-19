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
$per = 5;//每頁呈現幾筆
$pages = ceil($nums/$per);//(總筆數/每頁呈現幾筆),會出現幾頁
$page=empty($_GET['page'])?1:(int)$_GET['page'];//取get值
$pagestart = ($page-1)*$per;//每頁從陣列['0']開始顯示
$range=10;//每頁顯示的頁碼數
$start = (int)(($page-1) / $range) * $range + 1;  //$start是設定顯示每頁頁碼的開始值
$end = $start + $range -1;  //$end是設定顯示每頁頁碼的結束值
$sql2.= " LIMIT $pagestart,$per";//陣列['0']開始顯示,呈現幾筆
$re2 = $link->prepare($sql2);
$re2->execute();
$row2 = $re2->fetchall();

// $race_nameSqlNums=$race_nameSqlResult->rowcount();
// $race_nameSqlPer=10;//每頁呈現幾筆
// $race_nameSqlPages=ceil($race_nameSqlNums/$race_nameSqlPer);//(總筆數/每頁呈現幾筆),會出現幾頁
// $race_nameSqlPage=!isset($_GET['race_nameSqlPage'])?1:(int)$_GET['race_nameSqlPage'];//取get值
// $race_nameSqlStart=($race_nameSqlPage-1)*$race_nameSqlPer;//每頁從陣列['0']開始顯示
// $race_nameSqlRange=10;//每頁顯示的頁碼數
// $start = (int)(($race_nameSqlPage-1) / $race_nameSqlRange) * $race_nameSqlRange + 1;  //$start是設定顯示每頁頁碼的開始值
// $end = $start + $race_nameSqlRange -1;  //$end是設定顯示每頁頁碼的結束值
// $race_nameSql.=" LIMIT $race_nameSqlStart,$race_nameSqlPer";//陣列['0']開始顯示,呈現幾筆
// $race_nameSqlResult=$link->prepare($race_nameSql);
// $race_nameSqlResult->execute();
// $race_nameSqlRows=$race_nameSqlResult->fetchall();
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
    //  echo "<a href=?page=1>首頁</a>"."　";
    //  for($i=1;$i<=$pages;$i++)
    //  {
    //    if($i == $page)
    //   {
    //     echo '<font size="10">'.$i.'</font>'."　";
    //   }
    //   else
    //   {
    //     echo '<a href="?page='.$i.'">'.$i.'</a>'."　";
    //   }
    // }
    // echo "　"."<a href=?page=".$pages.">末頁</a>";

    echo $page==1?'':'<a href=?page=1>首頁</i></a>'.'　';
    echo $page==1?'':'<a href=?page='.($page-1).'>上一頁</a>'.'　';//上一頁
    if($pages <= $range)
    { //開始輸出頁碼
      for($i=1;$i<=$pages;$i++)
      {
        echo $i==$page ? '<a>'.$i.'</a>'.'　':'<a href="?&page='.$i.'">'.$i.'</a>'.'　';//當前顯示頁不會有連結,且放大
      }
    }
    else
    { //如果總頁數大於每頁要顯示的頁碼數
      //如果目前的頁數大於5，預設定為第6頁開始，每頁的頁碼就往前移動1位  ex 目前的頁數為第6頁，所以輸出 2 3 4 5 6 7 8 9 10 11，如果是第7頁就輸出 3 4 5 6 7 8 9 10 11 12，依此類推
      if($page > 5)
      {
        $end = $page+5;  //每頁結尾的頁碼就+5
        if ($end > $pages)
        {  //如果每頁結尾的頁碼大於總頁數
          $end = $pages;  //就將每頁結尾的頁碼改寫為最後一頁
        }
        $start = $end-9;  //將每頁開頭的頁碼設為結尾的頁碼-9
        //開始輸出頁碼
        for($i=$start; $i<=$end; $i++)
        { //在目前頁數裡本身頁數的頁碼就不要連結，如果不是就加上連結
          echo $i==$page ? '<a>'.$i.'</a>'.'　':'<a href="?page='.$i.'">'.$i.'</a>'.'　';//當前顯示頁不會有連結,且放大
        }
      }
      else
      { //如果目前的頁數小於5
        if ($end > $pages)
        { //如果每頁結尾的頁碼大於總頁數
          $end = $pages;  //就將每頁結尾的頁碼改寫為最後一頁
        }
        //開始輸出頁碼
        for($i=$start; $i<=$end; $i++)
        { //在目前頁數裡本身頁數的頁碼就不要連結，如果不是就加上連結
          echo $i==$page ? '<a>'.$i.'</a>'.'　':'<a href="page='.$i.'">'.$i.'</a>'.'　';//當前顯示頁不會有連結,且放大
        }
      }
    }
    echo $page==$pages?'':'　'.'<a href=?page='.($page+1).'>下一頁</a>';//下一頁
    echo $page==$pages?'':'　'.'<a href=?page='.$pages.'>末頁</i></a>';
    echo '<a>共'.$pages.'頁</a>';  //顯示目前總頁數
    echo '<a>共'.$nums.'筆</a>'; //顯示總筆數
  ?>
   </p>
  </body>

</html>
