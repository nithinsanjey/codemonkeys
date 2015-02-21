<?php
    session_start(); // Starting Session
    $error=''; // Variable To Store Error Message
    if (empty($_POST['username']) || empty($_POST['password']))
    {
        $error = "Username or Password is invalid";
    }
    else
    {
        $username=$_POST['username'];
        $password=$_POST['password'];
        $email=$_POST['email'];
        $connection = mysql_connect("localhost", "root", "") or die("Cannot connect");
        $username = stripslashes($username);
        $password = stripslashes($password);
        $username = mysql_real_escape_string($username);
        $password = mysql_real_escape_string($password);
        $db = mysql_select_db("webaholic", $connection) or die("Cannot select db");
        $query = mysql_query("select * from members where email='$email'");
        $rows = mysql_num_rows($query);
        if ($rows > 0)
        {
            echo "Already Registered. Please Login";
            header("refresh:0;url=index.php");
        } 
        else 
        {
            $query=mysql_query("INSERT INTO `members`(`EMAIL`, `USERNAME`, `PASSWORD`) VALUES ('$email','$username','$password')");
            echo '<html><title>Registered!!<title><body><link rel="stylesheet" type="text/css" href="bootstrap.css" />
            <div id="options" class="alert alert-success"><strong>Registered successfully.</strong> Redirecting to the login page,please wait....<br>If not, <a href="index.php">click here</a></div></body></html>';
            header("refresh:0;url=index.php");
        }
        mysql_close($connection); // Closing Connection
    }
?>