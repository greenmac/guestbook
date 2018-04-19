<?php include_once("../link.php"); ?>
<?php include_once('back_session.php');?>
<?php

$sql1 = "select g_seq ,g_name ,g_gender ,g_mobile ,g_email ,g_con ,mypostal ,city ,area ,address
         from guest as g1
         inner join sys_map_city as s1 on g1.mycity = s1.smcid
         inner join sys_map_area as s2 on g1.myarea = s2.smaid
         order by g_seq desc";

$re1 = $link->prepare($sql1);
$re1 -> execute();
$row1 = $re1->fetchall();

$nums = $re1->rowcount();
$per = 5;//每頁呈現幾筆
$pages = ceil($nums/$per);//(總筆數/每頁呈現幾筆),會出現幾頁
$page=empty($_GET['page'])?1:(int)$_GET['page'];//取get值
$pagestart = ($page-1)*$per;//每頁從陣列['0']開始顯示
$range=10;//每頁顯示的頁碼數
$start = (int)(($page-1) / $range) * $range + 1;  //$start是設定顯示每頁頁碼的開始值
$end = $start + $range -1;  //$end是設定顯示每頁頁碼的結束值
$sql1.= " LIMIT $pagestart,$per";//陣列['0']開始顯示,呈現幾筆
$re1 = $link->prepare($sql1);
$re1->execute();
$row1 = $re1->fetchall();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <style>
    /*
			body{font:12px/1.2 Verdana, sans-serif; padding:0 10px;}
			a:link, a:visited{text-decoration:none; color:#416CE5; border-bottom:1px solid #416CE5;}
			h2{font-size:13px; margin:15px 0 0 0;}
    */
		</style>
    <link rel="stylesheet" href="../colorbox/example4/colorbox.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <!--<script src="../colorbox/jquery.colorbox-min.js"></script>-->
    <script src="../colorbox/jquery.colorbox.js"></script>
  </head>
  <body>
    <table align="center" border="1" cellspacing="0">
      <tr align="center">
        <td colspan="10">使用者:<?php echo $_SESSION['myname']?></td>
        <td><a href="back_logout.php">登出</a></td>
      </tr>
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
        <td colspan="2">操作</td>
      </tr>
      <?php
      foreach($row1 as $row1)
      {
      ?>
      <tr align="center">
        <td><a class="group1" href="back_colorbox.php?name=<?php echo $row1['g_seq'];?>"><?php echo $row1['g_name'];?></td>
        <td>
        <?php
        echo $row1['g_gender']==1?"男":"女";
        ;?></td>
        <td><?php echo $row1['g_mobile'];?></td>
        <td><?php echo $row1['g_email'];?></td>
        <td><?php echo $row1['g_con'];?></td>
        <td><?php echo $row1['mypostal'];?></td>
        <td><?php echo $row1['city'];?></td>
        <td><?php echo $row1['area'];?></td>
        <td><?php echo $row1['address'];?></td>
        <td><a href="back_update.php?up=<?php echo $row1['g_seq'];?>"><input type="button" name="update" id="update" value="編輯"></a></td>
        <td><a href="back_delete.php?del=<?php echo $row1['g_seq'];?>"><input type="button" name="del" id="del" value="刪除"></a></td>
      </tr>
    <?php
    };
    ?>
    </table>
    <p align="center">
    <?php
    // echo "共".$nums."筆-在第".$page."頁-共".$pages."頁"."<br>";
    // echo "<a href=?page=1>首頁</a>";
    // echo "第";
    // for ($i=1;$i<=$pages;$i++)
    // {
    //     if($i==$page)
    //     {
    //       echo '<font size=10>'.$i.'</font>'."　";
    //     }else{
    //       echo '<a href="?page='.$i.'">'.$i.'</a>'."　";
    //     }
    // }
    // echo " 頁 <a href=?page=".$pages.">末頁</a><br /><br />";

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
   <script>
         $(document).ready(function()
         {
      				//Examples of how to assign the Colorbox event to elements
      				$(".group1").colorbox({rel:'group1'});
      				$(".group2").colorbox({rel:'group2', transition:"fade"});
      				$(".group3").colorbox({rel:'group3', transition:"none", width:"75%", height:"75%"});
      				$(".group4").colorbox({rel:'group4', slideshow:true});
      				$(".ajax").colorbox();
      				$(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
      				$(".vimeo").colorbox({iframe:true, innerWidth:500, innerHeight:409});
      				$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
      				$(".inline").colorbox({inline:true, width:"50%"});
      				$(".callbacks").colorbox({
      					onOpen:function(){ alert('onOpen: colorbox is about to open'); },
      					onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
      					onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
      					onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
      					onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
      				});

      				$('.non-retina').colorbox({rel:'group5', transition:'none'})
      				$('.retina').colorbox({rel:'group5', transition:'none', retinaImage:true, retinaUrl:true});

      				//Example of preserving a JavaScript event for inline calls.
      				$("#click").click(function()
              {
      					$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
      					return false;
      				});
      	 });

   </script>
  </body>
</html>
