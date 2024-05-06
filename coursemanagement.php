<?php
    error_reporting(E_ALL ^ E_NOTICE);
    require 'master.php';
	include_once 'connectionfile.php';
	
if (!isset($_SESSION['email'])) {
    header('Location: login.php'); 
    exit();
}

$email = $_SESSION['email'];
$sql = "SELECT faculty FROM tbluser WHERE email = '$email'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $faculty = $row['faculty'];

    if ($faculty == 0) {

        header('Location: index.php'); 
        exit();
    }
} else {
    echo "Error: Unable to retrieve user data.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Current Course Offerings</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.css"></script>
</head>
<body>

	<?php require_once 'master.php';?>
	<div class="container text-center">
	<h1>Course Management</h1>
		    <!-- Adding a course -->
			<form action="add_course.php" method="post">
				<label for="courseName">Course Name:</label>
				<input type="text" id="courseName" name="courseName" required><br>

				<label for="courseNumber">Course Number:</label>
				<input type="text" id="courseNumber" name="courseNumber" required><br>

				<label for="availableSeats">Available Seats:</label>
				<input type="number" id="availableSeats" name="availableSeats" min="0" required><br>

				<input type="submit" value="Add Course">
			</form>

			<!-- Removing a course -->
			<form action="remove_course.php" method="post">
				<label for="courseID">Course ID:</label>
			<input type="number" id="courseID" name="courseID" min="1" required><br>

				<input type="submit" value="Remove Course">
			</form>

		<?php

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$courseName = $_POST['courseName'];
			$courseNumber = $_POST['courseNumber'];
			$availableSeats = $_POST['availableSeats'];

			$conn = mysqli_connect("localhost", "username", "password", "college_registration");

			mysqli_close($conn);
		}
		?>

		<!-- Display the list of courses -->
		<h1>Available Courses</h1>

    <?php
			include_once 'connectionfile.php';

			$sql = "SELECT courseID, courseNumber, courseName FROM courses";
			$result = mysqli_query($conn, $sql);

			if ($result && mysqli_num_rows($result) > 0) {
				echo '<select name="Course" id="coursesDrop">';
				echo '<option value="">Please Select</option>';

				while ($row = mysqli_fetch_assoc($result)) {
					$courseID = $row['courseID'];
					$courseNumber = $row['courseNumber'];
					$courseName = $row['courseName'];

					echo "<option value='$courseID'>$courseID - $courseNumber - $courseName</option>";
				}

				echo '</select>';
			} else {
				echo "No courses found.";
			}

		mysqli_close($conn);
    ?>
	</div>
</body>
</html>