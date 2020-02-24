<?php
ob_start();
session_start();

$blog_host = 'localhost';
$blog_user = 'root';
$blog_pass = '';
$blog_name = "zhassulan";


$blog = new PDO("mysql:host=".$blog_host.";dbname=".$blog_name, $blog_user, $blog_pass);
$blog->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

date_default_timezone_set("Asia/Aqtobe");

if (isset($_SESSION['admin']))
  {
    $admin     = $_SESSION['admin'];
    $enter = TRUE;
  }
 else
 {
  $enter = FALSE;
 }

 
include('functions.php');
?>