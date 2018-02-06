<?php 
require 'app/functions.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$first_name = trim(filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING));
	$last_name = trim(filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING));
	$username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
	$email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING));
	$password = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));
	if (register($first_name, $last_name, $username, $email, $password)) {
		log_in($username, $password);
		header('Location:todo.php');
	}else{
		echo "Sorry, something went wrong";
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Shadows+Into+Light+Two" rel="stylesheet">
	<meta name="viewport" content="width=device-width" initial-scale=1.0>
</head>
<body>
<div class="list">
 	<h1 class="header">Register.</h1>
 	<form class="item-add" action="register.php" method="post">
 		<input type="text" name="first_name" placeholder="First Name" class="input" autocomplete="on" required>
 		<input type="text" name="last_name" placeholder="Last Name" class="input" autocomplete="on">
 		<input type="text" name="username" placeholder="Username" class="input" autocomplete="on" required>
 		<input type="text" name="email" placeholder="Email" class="input" autocomplete="on" required>
 		<input type="password" name="password" placeholder="Password" class="input" autocomplete="on" required>
 		<input type="submit" value="Register" name="Sign in" class="submit">
 	</form>
 </div>
</body>
</html>