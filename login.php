<?php
error_reporting(E_ALL ^ E_NOTICE);

// Include master.php file
require_once 'master.php';

// Include connectionfile.php for database connection
require_once 'connectionfile.php';

// Start the session
session_start();

if (isset($_SESSION['email'])) {
    // If user is already logged in, redirect to master.php
    header("Location: master.php");
    exit();
}

if (isset($_POST['login'])) {
    // Get the input values from the login form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate the input values
    if (empty($email) || empty($password)) {
        $error_msg = "Please enter your email and password.";
    } else {
        $email = mysqli_real_escape_string($conn, $email);
        $password = mysqli_real_escape_string($conn, $password);

        $query = "SELECT * FROM tbluser WHERE email='$email'";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            $error_msg = "Error executing query: " . mysqli_error($conn);
        } else {
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                if ($password == $row['password']) {
                    // Set the session variable and redirect to the master.php file
                    $_SESSION['email'] = $row['email'];
                    header("Location: master.php");
                    exit();
                } else {
                    $error_msg = "Incorrect password.";
                }
            } else {
                $error_msg = "No user found with that email address.";
            }
        }
    }
}
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
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <h2>Login</h2>
                <?php if (isset($error_msg)) { ?>
                    <div class="alert alert-danger"><?php echo $error_msg; ?></div>
                <?php } ?>
                <form method="POST">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-primary" name="login">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
