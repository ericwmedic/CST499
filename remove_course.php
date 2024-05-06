<?php
include_once 'connectionfile.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $courseID = intval($_POST['courseID']); 

    $sql = "DELETE FROM courses WHERE courseID = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, 'i', $courseID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        mysqli_query($conn, "UPDATE courses SET availableSeats = availableSeats + 1 WHERE courseID = '$courseID'");

        header("location: courses.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>