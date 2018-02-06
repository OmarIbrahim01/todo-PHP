<?php 
session_start();
require 'app/functions.php';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$user_name = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
	$password = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));
	if(log_in($user_name, $password)){
		header('Location:todo.php');
	}else{
		echo "Inncorect username or password8";
	}
}

if (user_loged_in()){
	header('Location:todo.php');
	
}

if(isset($_GET['log_out'])){
	log_out();
	header('Location:index.php');
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Sign In</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Shadows+Into+Light+Two" rel="stylesheet">
	<meta name="viewport" content="width=device-width" initial-scale=1.0>
</head>
<body>

 <div class="list">
 	<h1 class="header">Welcome to Todo, Please Sign In or <a href="register.php">Register</a></h1>
 	<form class="item-add" action="index.php" method="post">
 		<input type="text" name="username" placeholder="User Name" class="input" autocomplete="on" required>
 		<input type="password" name="password" placeholder="Password" class="input" autocomplete="on" required>
 		<input type="submit" value="Sign In" name="Sign in" class="submit">
 	</form>
 </div>
 
</body>
</html>