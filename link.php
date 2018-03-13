<?php
$link = new PDO('mysql:host=localhost; dbname=guestbook; charset=utf8',
                'root',
                'curry30');
$link->query("set names utf8");
/*
$link = @mysql_connect("localhost" ,"root" ,"1234" ,"a01");
mysql_query('SET NAMES "utf8"');
mysql_select_db("a01",$link);
*/
session_start();
 ?>
