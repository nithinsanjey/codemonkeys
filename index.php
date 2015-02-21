<!DOCTYPE HTML>
<?php
if(isset($_SESSION['username'])){
header("location: profile.php");
}
?>
<html>
	<meta charset="UTF-8">
	<head>
		<title>Online Portal</title>
		<style>
			body
			{
				maergin:0px;
				font :12px sans-serif;
			}
			#form
			{
				margin:100px 0px 0px 100px;
			}
		</style>
	</head>
	<link rel="stylesheet" type="text/css" href="bootstrap.css">
	<body>
		<div id="form">
		<div id="register" style="float:left">
			<form class="form-horizontal" action="register.php" method="post">
<div class="form-group">
  <div class="col-md-10">
  <input id="email" name="email" type="email" placeholder="Email" class="form-control input-md" required>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">  
  <div class="col-md-10">
  <input id="username" name="username" type="text" placeholder="Username" class="form-control input-md" required>
    
  </div>
</div>

<!-- Password input-->
<div class="form-group">
  <div class="col-md-10">
    <input id="password" name="password" type="password" placeholder="Password" class="form-control input-md" title="Atlest 1 uppercase, 1lowercase, 1 number and 1 special  character and minimum 8 characters." pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$" required>
    
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <div class="col-md-4">
    <input type="submit" id="submit" name="submit" class="btn btn-primary" value="Register">
  </div>
</div>
</form>

		</div>
		<div id="login" style="float:left">
			<form class="form-horizontal" action="login.php" method="post">
<div class="form-group">
  <div class="col-md-10">
  <input id="username" name="username" type="text" placeholder="Username" class="form-control input-md" required>
    
  </div>
</div>

<!-- Password input-->
<div class="form-group">
  <div class="col-md-10">
    <input id="password" name="password" type="password" placeholder="Password" class="form-control input-md" required>
    
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <div class="col-md-10">
    <input type="submit" id="submit" name="submit" class="btn btn-primary" value="Login">
  </div>
</div>
			</form>
		</div>
		</div>
	</body>
</html>
