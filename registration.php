<?php
	error_reporting(E_ALL ^ E_NOTICE);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title> Registration Page</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device=width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.css"></script>
</head>
<body>
	
	<?php include 'master.php';?>

	<div class="container text-center">
		<h1>New Account</h1>
	</div>

	<?php include 'footer.php';?>

	<div class="container text-center">
		<div class="header">
			<h2>Create a New Account</h2>



			<form action = "databaseconnection/signup.php" method = "post">

				<input type = "text" name = "email" placeholder = "Email">
				<br>
				<input type = "password" name = "password" placeholder = "Password">
				<br>
				<input type = "text" name = "firstName" placeholder = "First Name">
				<br>
				<input type = "text" name = "lastName" placeholder = "Last Name">
				<br>
				<input type = "text" name = "address" placeholder = "Address">
				<br>
				<input type = "text" name = "phone" placeholder = "Phone">
				<br>
				<button type = "submit" name = "submit" > Submit </button>
				<br>


			</form>
		</div>
	</div>
</body>
</html>

