<?php
include_once("../link.php");

$phpbb_root_path = defined('PHPBB_ROOT_PATH') ? PHPBB_ROOT_PATH : './';
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header('Content-type: text/html; charset=utf-8');
header('Vary: Accept-Language');
date_default_timezone_set('Asia/Taipei');
mb_internal_encoding("UTF-8");

$session_id =0;
if(isset($_SESSION['session_id']) && trim($_SESSION['session_id'])){
	$session_id =$_SESSION['session_id'];
}else{
	$session_id = (time()%10000).''.mt_rand(10000000,99999999);
	$_SESSION['session_id']=$session_id;
}
?>
<?php
if(isset($_POST['u_name']) && isset($_POST['u_password']))
{
  $_SESSION['myname'] = $_POST['u_name'];

  $check_err_msg='';
  $check_resp_code=0;

  $sql2="SELECT * from user where u_name = '".$_POST['u_name']."' and u_password = '".$_POST['u_password']."'";
  $re2 = $link->query($sql2);
  $row2 = $re2->fetch();

  //print_r($row2);
  //  if($row2['u_password'] != $_POST['u_password'])
  if(!empty($row2))
  {
        $_captcha	=isset($_POST['ct_captcha'])&& trim($_POST['ct_captcha'])	? trim($_POST['ct_captcha']): '';
        //$session_id =isset($_POST['session_id'])&& trim($_POST['session_id'])	? trim($_POST['session_id']): '';

        if($_captcha&&$session_id)
        {
            if($session_id!=$_SESSION['session_id'])
            {
              $check_err_msg = '禁止不正常發送動作，即將返回首頁！';
            }
            else
            {
              require_once($phpbb_root_path.'js/securimage/securimage.php');
              $securimage = new Securimage();
              if($securimage->check($_captcha))
              {
                $check_err_msg="驗證成功！";
              }
              else
              {
								$check_resp_code=1;
                $check_err_msg = '驗證碼輸入錯誤，請重新輸入！';
              }
              unset($securimage);
            }
        }
  }
  else
  {
    $check_resp_code=1;
    $check_err_msg="帳號或密碼輸入錯誤！";
  }

  if($check_resp_code ==0)
  {
    echo '<script>alert("'.$check_err_msg.'"); document.location.href="back_admin.php";</script>';
  }
  elseif($check_resp_code ==1)
  {
    echo '<script>alert("'.$check_err_msg.'");</script>';
  }

}
//echo '2__'.$session_id;
//echo '</br>';
//echo '$session_id='.$session_id;
//print_r($_SESSION);
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
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
            <!--<td colspan="2"><a onclick="javascript:on_submit();return false;" href="#">送出</a></td>-->
            <td colspan="2"><?php include_once("example1.php");?></td>
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
	      if (!u_password.val()){
	        u_password.focus();
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
