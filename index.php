<?php include_once('link.php');?>
<?php
if((!empty($_POST['g_name'])) && (!empty($_POST['g_ra'])) && (!empty($_POST['g_mobile'])) && (!empty($_POST['g_email'])))
  {
    $_SESSION['g_name'] = $_POST['g_name'];
    $_SESSION['g_ra'] = $_POST['g_ra'];
    $_SESSION['g_mobile'] = $_POST['g_mobile'];
    $_SESSION['g_email'] = $_POST['g_email'];
    $_SESSION['mycity'] = $_POST['mycity'];
    $_SESSION['mypostal'] = $_POST['mypostal'];
    $_SESSION['myarea'] = $_POST['myarea'];
    $_SESSION['mycity'] = $_POST['mycity'];
    $_SESSION['address'] = $_POST['address'];

    header("Location:guest_admin.php");
  }
  $sql1 = "select * from sys_map_city where status = 1";
  $result1 = $link->prepare($sql1);
  $result1->execute();
  $row1 = $result1->fetchall();
/*
  print_r($_POST);
  echo "<br>";
  var_dump($_POST);
*/
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="jquery-validation-1.17.0\demo\css\screen.css">
<script src="jquery-validation-1.17.0\lib\jquery.js"></script>
<script src="jquery-validation-1.17.0\dist\jquery.validate.js"></script>

  </head>
  <body>
    <form name="postform" id="postform" method="post" action="index.php" autocomplete="off" >
    <table border="1" align="center" cellspacing="0">
      <tr align="center">
         <td>暱稱</td>
         <td><input type="text" name="g_name" id="g_name" value=""/></td>
      </tr>
      <tr align="center">
        <td colspan="2">
        男<input type="radio" value="1" name="g_ra" id="g_ra" checked="checked"/>
        女<input type="radio" value="2" name="g_ra" id="g_ra"/>
      </td>
      </tr>
      <tr align="center">
        <td>手機</td>
        <td><input type="text" name="g_mobile" id="g_mobile"/></td>
      </tr>
      <tr align="center">
        <td>email</td>
        <td><input type="text" name="g_email" id="g_email"/></td>
      </tr>
      <tr align="center">
        <td>地址:</td>
        <td>
          <input id="mypostal" name="mypostal" type="text" size="3"  value="" readonly>
          <select class="" name="mycity" id="mycity">
            <option value="">請選擇</option>
            <?php foreach($row1 as $row1){;?>
            <option value="<?php echo $row1['smcid'];?>"><?php echo $row1['city'];?></option>
            <?php };?>
          </select>
          <select class="" name="myarea" id="myarea">
            <option value="">請選擇</option>
          </select>
          </td>
      </tr>
      <tr align="center">
        <td colspan="2"><input type="text" id="address" name="address" size=40></td>
      </tr>
      <tr align="center">
        <td colspan="2">
          <input type="submit" id="on_submit123" value="登入">
          <!--<input type="submit" id="on_submit123" onclick="on_submit();" value="登入">-->
          <!--<a onclick="javascript:on_submit; return false;" href="#" class="login_btn">登入</a>-->
        </td>
      </tr>
      <!--<span id="asdf"></span>-->
    </table>
  </form>
  <script>

/*
  function on_submit()

    {
      var g_name =$("#g_name");
      if(!g_name.val()){
        g_name.focus();
        alert("尚未輸入暱稱");
        return;
      }

      var g_ra =0;
      for(i=0;i<postform.g_ra.length;i++){
        if(postform.g_ra[i].checked){
          g_ra++;
        }
      }
         if(g_ra == 0){
           alert("尚未輸入性別");
           return;
         }

      var g_mobile =$("#g_mobile");
      if(!g_mobile.val()){
        g_mobile.focus();
        alert("尚未輸入手機");
        return;
      }else{
          var re1 =/^09[0-9]{2}[0-9]{6}$/;
          if(!re1.test(g_mobile.val()))
          {
            alert("請輸入正確手機號碼");
            return;
           }
      }

      var g_email =$("#g_email");
      if(!g_email.val()){
        g_email.focus();
        alert("尚未輸入email");
        return;
      }else{
          var re2 =/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/;
          if(!re2.test(g_email.val()))
          {
            alert("請輸入正確email");
            return;
           }
      }

      var mycity =$("#mycity");
      if(!mycity.val()){
        mycity.focus();
        alert("請選擇城市");
        return;
      }

      var myarea =$("#myarea");
      if(!myarea.val()){
        myarea.focus();
        alert("請選擇行政區");
        return;
      }

      var address =$("#address");
      if(!address.val()){
        address.focus();
        alert("請填選地址");
        return;
      }

    $("#postform").submit();
  }
*/
  $(document).ready(function()
  {
            //利用jQuery的ajax把縣市編號(CNo)傳到Town_ajax.php把相對應的區域名稱回傳後印到選擇區域(鄉鎮)下拉選單
            $('#mycity').change(function(){
                var CNo= $('#mycity').val();
                $.ajax({
                    type: "POST",
                    url: 'guest_city_ajax.php',
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
                        url: 'guest_area_ajax.php',
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
////////////////////////////////////////////////////////////////////////
/*
$.validator.setDefaults({
  submitHandler: function() {
    //alert("submitted!");
  }
});
*/
//$(document).ready(function()
//{
  // validate signup form on keyup and submit
  // 手机号码验证
  jQuery.validator.addMethod("isMobile", function(value, element) {
      var length = value.length;
      var mobile = /^09[0-9]{2}[0-9]{6}$/;
      return this.optional(element) || (length == 10 && mobile.test(value));
  }, "請正確填寫您的手機");
  $("#postform").validate({
    rules:
    {
      g_name: {
        required: true,
        //minlength: 2
      },
      g_mobile: {
        required: true,
        digits: true,
        isMobile: true,
        minlength: 10,
        maxlength: 10
      },
      g_email: {
        required: true,
        email: true
      },
      mycity: "required",
      myarea: "required",
      address: "required",
    },

    messages:
    {
      g_name:{
        required:"請輸入暱稱",
        //minlength: "Your firstname must consist of at least 2 characters"
      },
      g_mobile: {
        required: "請輸入手機",
        isMobile: "請輸入09開頭的10碼號碼",
        minlength: "請輸入正確手機號碼格式長度",
        maxlength: "請輸入正確手機號碼格式長度",
        digits: "請輸入數字"
      },
      g_email: {
        required: "請輸入email",
        //minlength: "Your password must be at least 10 characters long",
      },
      mycity: {
        required: "請輸入城市",
      },
      myarea: {
        required: "請輸入行政區",
      },
      address: {
        required: "請輸入地址",
      }
    }
  });
//});

</script>
</body>
</html>
