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
        $connection = mysql_connect("localhost", "root", "") or die("Cannot connect");
        $username = stripslashes($username);
        $password = stripslashes($password);
        $username = mysql_real_escape_string($username);
        $password = mysql_real_escape_string($password);
        // Selecting Database
        $db = mysql_select_db("webaholic", $connection) or die("Cannot select db");
        $query = mysql_query("select * from members where password='$password' AND username='$username'");
        $rows = mysql_num_rows($query);
        if ($rows > 0)
        {
            if($row=mysql_fetch_array($query))
            {
                $_SESSION['username']=$username;
				$_SESSION['email']=$row['EMAIL'];
                header("location:home.php");
            }
        } 
        else 
        {
            $error = "Username or Password is invalid";
			echo $error;
			echo "Please, try again. Redirecting, if not <a href=index.php>click here</a>";
			header("refresh:0;url=index.php");
        }
        mysql_close($connection); // Closing Connection
    }
?>