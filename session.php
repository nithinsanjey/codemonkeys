<?php
$connection = mysql_connect("localhost", "root", "");
$db = mysql_select_db("webaholic", $connection);
session_start();
$user_check=$_SESSION['username'];
$ses_sql=mysql_query("select username from members where username='$user_check'");
$row = mysql_fetch_assoc($ses_sql);
$login_session =$row['USERNAME'];
if(!isset($_SESSION['$login_session'])){
mysql_close($connection); // Closing Connection
header('Location: index.php'); // Redirecting To Home Page
}
?>