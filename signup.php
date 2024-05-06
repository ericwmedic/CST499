<?php 
    include_once 'connectionfile.php';

    // Get user input and sanitize it
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    // Create the SQL statement with placeholders
    $sql = "INSERT INTO tbluser (email, password, firstName, lastName, address, phone) VALUES (?, ?, ?, ?, ?, ?)";

    // Use prepared statements to prevent SQL injection attacks
    if ($stmt = mysqli_prepare($conn, $sql)) {
		mysqli_stmt_bind_param($stmt, 'ssssss', $email, $password, $firstName, $lastName, $address, $phone);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("location: ../registration.php?signup=success");
    } else {
        // If the SQL query fails, inform the user of the error
        echo "Error: " . mysqli_error($conn);
    }
?>