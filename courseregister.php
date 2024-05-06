<?php
include_once 'connectionfile.php';
session_start();
if (isset($_SESSION['email'])) {
    $studentEmail = $_SESSION['email'];
    if (isset($_GET['courseID'])) {
        $courseID = intval($_GET['courseID']); 

        // Check if there are available seats for the course
        $checkSeatsSql = "SELECT availableSeats FROM courses WHERE courseID = ?";
        $stmt = $conn->prepare($checkSeatsSql);
        $stmt->bind_param("i", $courseID);
        $stmt->execute();
        $result = $stmt->get_result();
        $availableSeats = mysqli_fetch_row($result)[0];

        $waitlist = $availableSeats > 0 ? 0 : 1;

        $insertSql = "INSERT INTO registrations (email, courseID, waitlist) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertSql);
        $stmt->bind_param("sii", $studentEmail, $courseID, $waitlist);
        if ($stmt->execute()) {
            // If the student is not waitlisted, decrease the number of available seats
            if ($waitlist == 0) {
                $updateSeatsSql = "UPDATE courses SET availableSeats = availableSeats - 1 WHERE courseID = ?";
                $stmt = $conn->prepare($updateSeatsSql);
                $stmt->bind_param("i", $courseID);
                $stmt->execute();
            }
            echo '<script>alert("Successfully registered for the class.");</script>';
            header("Location: profile.php");
            exit();
        } else {
            echo 'Error: ' . $stmt->error;
        }
    } else {
        echo 'Invalid request.';
    }
} else {
    echo 'Session error: Email not found.';
}
$conn = null;
?>