<?php
	error_reporting(E_ALL ^ E_NOTICE);
	include_once 'connectionfile.php';
	ini_set('session.use_only_cookies','1');
	session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="jumbotron">
		<div class="container text-center">
			<h1 style="border-style: double; padding: 3px; margin: 5px; border-radius: 20px;">Student Registration Portal</h1>
		</div>
	</div>
	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="index.php">
							<span class="glyphicon glyphicon-home"></span>
							Home
						</a>
					</li>
					<?php
					// Check if the session is active (user is logged in)
					if (isset($_SESSION['email'])) {
						$email = $_SESSION['email'];
						$sql = "SELECT faculty FROM tbluser WHERE email = '$email'";
						$result = mysqli_query($conn, $sql);

						if ($result && mysqli_num_rows($result) > 0) {
							$row = mysqli_fetch_assoc($result);
							$faculty = $row['faculty'];

							echo '<li class="active">';
							if ($faculty == 0) {
								echo '<a href="classregister.php">';
								echo '<span class="glyphicon glyphicon-book"></span>';
								echo 'Register for Classes';
								echo '</a>';
							} elseif ($faculty == 1) {
								echo '<a href="coursemanagement.php">';
								echo '<span class="glyphicon glyphicon-book"></span>';
								echo 'Course Management';
								echo '</a>';
							}
							echo '</li>';
						} else {
							echo 'No data found.';
						}
					}
					?>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<?php
						if (isset($_SESSION['email'])) {
							echo '<li><a href="#"><span class="glyphicon glyphicon-user"></span> Welcome: ' . $_SESSION['email'] . '</a></li>';
							echo '<li><a href="profile.php"><span class="glyphicon glyphicon-briefcase"></span> Profile</a></li>';
							echo '<li><a href="index.php?Logout=1"><span class="glyphicon glyphicon-off"></span> Logout</a></li>';
							if (isset($_GET['Logout']) && $_GET['Logout'] == 1) {
								session_unset();
								header("Location: index.php");
							}
						} else {
							echo '<li><a href="login.php"><span class="glyphicon glyphicon-user"></span> Login</a></li>';
							echo '<li><a href="Registration.php"><span class="glyphicon glyphicon-pencil"></span> Create an Account</a></li>';
						}
					?>
				</ul>
			</div>
		</div>
	</nav>
</body>
</html>