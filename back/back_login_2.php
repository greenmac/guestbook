<?php include_once("../link.php"); ?>
<?php
$error = 0;
if(!empty($_POST['u_name'])){
  if(!empty($_POST['u_password'])){
    //$loginusername = $_POST['u_name'];
    //$_SESSION['myname'] = $loginusername;

    $sql1 = "SELECT count(*) as logincount from user where u_name = '".$_POST['u_name']."' and u_password = '".$_POST['u_password']."'";
    $re1 = mysql_query($sql1);
    $row1 = mysql_fetch_assoc($re1);

    if ($row1['logincount'] == 1){
      $_SESSION['myname'] = $_POST['u_name'];
    }else{
      $error=1;
    }
    mysql_free_result($re1);
  }
}

if(!empty($_SESSION['myname'])){
  header("Location:back_admin.php");
}

 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
  <form method="post" id="postform" name="postform" autocomplete="off">
        <table align="center" border="1" cellspacing="0">
          <tr align="center">
            <td>帳號</td>
            <td><input type="text" name="u_name" id="u_name"/></td>
          </tr>
          <tr align="center">
            <td>密碼</td>
            <td><input type="password" name="u_password" id="u_password"/></td>
          </tr>
          <tr align="center">
            <td colspan="2"><input type="submit" value="登入" name="login" id="login"/></td>
            <!--<td colspan="2"><?php include_once("example1.php")?></td>-->
          </tr>
        </table>
    </form>
    <script type="text/javascript">

    function on_submit()
    {
      var u_name =$("#u_name");
      if (!u_name.val()){
        u_name.focus();
        alert("尚未輸入帳號");
        return;
      }

      var u_password =$("#u_password");
      if (!u_name.val()){
        u_name.focus();
        alert("尚未輸入密碼");
        return;
      }

    	var ct_captcha	=$("#ct_captcha");
      if(!ct_captcha.val()){
    		ct_captcha.focus();
    		alert("尚未輸入驗證碼");
    		return;
    	}
    	$("#postform").submit();
    }
    </script>
  </body>
</html>
