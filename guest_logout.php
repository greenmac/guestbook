<?php include_once('link.php');?>
<?php
$_SESSION['g_name'] = NULL;
/*
$_SESSION['g_ra'] = NULL;
$_SESSION['g_mobile'] = NULL;
$_SESSION['g_email'] = NULL;
unset($_SESSION['g_name']);
unset($_SESSION['g_ra']);
unset($_SESSION['g_mobile']);
unset($_SESSION['g_email']);
*/
header("Location:guest_login.php");
 ?>
