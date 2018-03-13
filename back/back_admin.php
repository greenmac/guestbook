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
$row1 = $re1->fetch();
$nums = $re1->rowcount();

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

$sql1.=" LIMIT $start,$per ";
$re1 = $link->prepare($sql1);
$re1->execute();
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
    <?php while($row1 = $re1->fetch()){;?>
      <tr align="center">
        <td><a class="group1" href="back_colorbox.php?name=<?php echo $row1['g_seq'];?>"><?php echo $row1['g_name'];?></td>
        <td><?php
        echo $row1['g_gender']==1?"男":"女";
        // if($row1['g_gender']==1){
        //   echo $row1['g_gender']="男";
        // }elseif($row1['g_gender']==2){
        //   echo $row1['g_gender']="女";
        // }
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
    <?php };?>
    </table>
    <p align="center">
    <?php
    echo "共".$nums."筆-在第".$page."頁-共".$pages."頁"."<br>";
    echo "<a href=?page=1>首頁</a>";
    echo "第";
    for ($i=1;$i<=$pages;$i++)
    {
        if($i==$page)
        {
          echo '<font size=10>'.$i.'</font>'."　";
        }else{
          echo '<a href="?page='.$i.'">'.$i.'</a>'."　";
        }
    }
    echo " 頁 <a href=?page=".$pages.">末頁</a><br /><br />";
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
