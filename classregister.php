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
    <h1>Available Classes</h1>

    <?php
	session_start();
    include_once 'connectionfile.php';

$sql = "SELECT * FROM courses";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    echo '<ul>';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<li>';
        echo $row['courseNumber'] . ' - ' . $row['courseName'];

        $email = $_SESSION['email'];
        $registered = false;
        $waitlisted = false;

        $checkRegistrationSql = "SELECT waitlist FROM registrations WHERE email = '$email' AND courseID = '{$row['courseID']}'";
        $registrationResult = mysqli_query($conn, $checkRegistrationSql);
        if ($registrationResult && mysqli_num_rows($registrationResult) > 0) {
            $registrationRow = mysqli_fetch_row($registrationResult);
			if ($registrationRow) {
				$registered = $registrationRow[0] == 0;
				$waitlisted = $registrationRow[0] == 1;
			}
        }

        if (!$registered && !$waitlisted) {
            if ($row['availableSeats'] > 0) {
                echo ' (<a href="courseregister.php?courseID=' . $row['courseID'] . '">Register</a>)';
            } else {
                echo ' (No available seats. <a href="waitlist.php?courseID=' . $row['courseID'] . '">Join Waitlist</a>)';
            }
        } else if ($registered) {
            echo ' (Registered)';
        } else if ($waitlisted) {
            echo ' (Waitlisted)';
        }

        echo '</li>';
    }
    echo '</ul>';
} else {
    echo 'No available classes.';
}

    mysqli_close($conn);
    ?>

	<p><a href="coursedrop.php">Unregister from a class</a></p>
	</div>
</body>
</html>