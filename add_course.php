<?php
include_once 'connectionfile.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $courseName = mysqli_real_escape_string($conn, $_POST['courseName']);
    $courseNumber = mysqli_real_escape_string($conn, $_POST['courseNumber']);
    $availableSeats = intval($_POST['availableSeats']);

    $sql = "INSERT INTO courses (courseName, courseNumber, availableSeats, waitlist) VALUES (?, ?, ?, 0)";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, 'ssi', $courseName, $courseNumber, $availableSeats);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $availableSeats--;

        if ($availableSeats === 0) {
            mysqli_query($conn, "UPDATE courses SET waitlist = waitlist + 1 WHERE courseName = '$courseName'");
        }

        header("location: courses.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>