<?php

error_reporting(E_ALL ^ E_NOTICE);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Student Profile</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body>

    <?php include 'master.php'; ?>

    <div class="container">
        <div class="header">
            <h2>Profile</h2>
        </div>
        <form action="profile.php" method="post">
            <div class="container text-center">
                <h1>Student Profile</h1>
            </div>
            <?php include 'footer.php'; ?>
        </form>
    </div>

    <div class="container text-center">
        <?php
        include 'connectionfile.php';

        $email = $_SESSION['email'];
		
		$sql = "SELECT u.*, c.courseNumber, r.waitlist
				FROM tbluser u
				LEFT JOIN registrations r ON u.email = r.email
				LEFT JOIN courses c ON r.courseID = c.courseID
				WHERE u.email = ?";

		$stmt = $conn->prepare($sql);
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$result = $stmt->get_result();

        if ($result && mysqli_num_rows($result) > 0) {
            echo '<div class="table-responsive">';
            echo '<table class="table table-bordered" cellpadding="10" cellspacing="5">';
            echo '<thead><tr>';
			echo '<th scope="col">Faculty (1 is Yes, 0 is No)</th>';
            echo '<th scope="col">First Name</th>';
            echo '<th scope="col">Last Name</th>';
            echo '<th scope="col">Email</th>';
            echo '<th scope="col">Password</th>';
            echo '<th scope="col">Address</th>';
            echo '<th scope="col">Phone</th>';
			echo '<th scope="col">Registered Courses</th>';
			echo '<th scope="col">Waitlisted?</th>';
            echo '</tr></thead>';
            echo '<tbody>';

            while ($row = mysqli_fetch_array($result)) {
                echo '<tr>';
				echo '<td>' . $row['faculty'] . '</td>';
                echo '<td>' . $row['firstName'] . '</td>';
                echo '<td>' . $row['lastName'] . '</td>';
                echo '<td>' . $row['email'] . '</td>';
                echo '<td>' . $row['password'] . '</td>';
                echo '<td>' . $row['address'] . '</td>';
                echo '<td>' . $row['phone'] . '</td>';
				echo '<td>' . $row['courseNumber'] . '</td>';
				echo '<td>' . ($row['waitlist'] ? 'Yes' : 'No') . '</td>';
                echo '</tr>';
            }

            echo '</tbody></table>';
            echo '</div>';
        } else {
            echo 'No data found.';
        }

        mysqli_close($conn);
        ?>
    </div>

</body>

</html>
