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

<?php
include_once 'connectionfile.php';
session_start();

if (isset($_SESSION['email'])) {
    $studentEmail = $_SESSION['email'];

    if (isset($_POST['courseID'])) {
        $courseID = intval($_POST['courseID']); 
        $deleteSql = "DELETE FROM registrations WHERE email = ? AND courseID = ?";
        $stmt = $conn->prepare($deleteSql);
        $stmt->bind_param("si", $studentEmail, $courseID);
        if ($stmt->execute()) {
            // Increase the number of available seats
            $updateSeatsSql = "UPDATE courses SET availableSeats = availableSeats + 1 WHERE courseID = ?";
            $stmt = $conn->prepare($updateSeatsSql);
            $stmt->bind_param("i", $courseID);
            $stmt->execute();

            echo '<script>alert("Successfully unregistered from the class.");</script>';
            header("Location: profile.php");
            exit();
        } else {
            echo 'Error: ' . $stmt->error;
        }
    } else {
        $sql = "SELECT c.courseID, c.courseNumber, c.courseName
                FROM courses c
                JOIN registrations r ON c.courseID = r.courseID
                WHERE r.email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $studentEmail);
        $stmt->execute();
        $result = $stmt->get_result();

        echo '<form action="coursedrop.php" method="post">';
        echo '<select name="courseID">';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['courseID'] . '">' . $row['courseNumber'] . $row['courseName'] . '</option>';
        }
        echo '</select>';
        echo '<input type="submit" value="Unregister">';
        echo '</form>';
    }
} else {
    echo 'Session error: Email not found.';
}

$conn = null;
?>
</body>
</html>