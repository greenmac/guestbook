<?php
##本機
$link = new PDO('mysql:host=localhost; dbname=guestbook; charset=utf8',
                'root',
                'curry30');

##伺服器
// $link = new PDO('mysql:host=sql309.byethost7.com; dbname=b7_21943652_guestbook; charset=utf8',
//                 'b7_21943652',
//                 'mac50787');

$link->query("set names utf8");

session_start();
 ?>
