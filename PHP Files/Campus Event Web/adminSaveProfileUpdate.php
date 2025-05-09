<?php
    include 'connection.php';  // Include the connection.php file to connect to the database.
    session_start();  // Start a new session or resume the existing one for the current user. (lecture 5)

    // Check if the session variable 'admin_name' is not set, which means the user is not logged in as an admin.
    if (!isset($_SESSION['admin_name'])) {
        header('location:login.php');  // Redirect the user to the login page if they are not logged in.
    }

    // Check if the form was submitted using the POST method
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get form inputs
        $id = $_POST["id"];
        $fname = mysqli_real_escape_string($con, $_POST["fname"]);
        $lname = mysqli_real_escape_string($con, $_POST["lname"]);
        $email = mysqli_real_escape_string($con, $_POST["email"]);
        $phonenumber = mysqli_real_escape_string($con, $_POST["phonenumber"]);
        $address = mysqli_real_escape_string($con, $_POST["address"]);
        $postcode = mysqli_real_escape_string($con, $_POST["postcode"]);
        $dob = mysqli_real_escape_string($con, $_POST["dob"]);

        // SQL query to update the profile information for the admin
        $sql = "UPDATE register SET 
                fname='$fname', 
                lname='$lname', 
                email='$email', 
                phonenumber='$phonenumber', 
                address='$address', 
                postcode='$postcode', 
                dob='$dob'
                WHERE ID = '$id' AND user_type = 'admin'";

        // Execute the query
        if (mysqli_query($con, $sql)) {
            // Set a session success message and redirect to the admin profile page
            $_SESSION['success_message'] = "Profile updated successfully!";
            header("Location: profileadmin.php");
        } else {
            // If the query failed, output the error message
            echo "Error: " . mysqli_error($con);
        }
    }
?>
