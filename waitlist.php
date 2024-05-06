<?php
include_once 'connectionfile.php';
session_start();

if (isset($_SESSION['email'])) {
    $studentEmail = $_SESSION['email'];
    if (isset($_GET['courseID'])) {
        $courseID = intval($_GET['courseID']); 

        // Check if the user is already registered for the course
        $checkRegistrationSql = "SELECT * FROM registrations WHERE email = ? AND courseID = ?";
        $stmt = $conn->prepare($checkRegistrationSql);
        $stmt->bind_param("si", $studentEmail, $courseID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && mysqli_num_rows($result) > 0) {
            // If registered, update the waitlist field
            $updateSql = "UPDATE registrations SET waitlist = 1 WHERE courseID = ? AND email = ?";
            $stmt = $conn->prepare($updateSql);
            $stmt->bind_param("is", $courseID, $studentEmail);
        } else {
            // If not registered, insert a new row with waitlist = 1
            $insertSql = "INSERT INTO registrations (email, courseID, waitlist) VALUES (?, ?, 1)";
            $stmt = $conn->prepare($insertSql);
            $stmt->bind_param("si", $studentEmail, $courseID);
        }

        if ($stmt->execute()) {
            echo '<script>alert("Successfully added to the waitlist.");</script>';
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