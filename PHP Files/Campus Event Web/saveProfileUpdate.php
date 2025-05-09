<?php
include 'connection.php';  // Include the database connection file
session_start();  // Start the session to maintain user login status

// Check if the user is logged in; if not, redirect them to the login page
if (!isset($_SESSION['user_name'])) {
    header('location:login.php');  // Redirect to login page if session is not set
}

// Check if the form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the submitted form data
    $id = $_POST["id"];  // The user ID to identify which record to update
    $fname = mysqli_real_escape_string($con, $_POST["fname"]);  // get the first name input
    $lname = mysqli_real_escape_string($con, $_POST["lname"]);  // get the last name input
    $email = mysqli_real_escape_string($con, $_POST["email"]);  // get the email input
    $phonenumber = mysqli_real_escape_string($con, $_POST["phonenumber"]);  // get the phone number input
    $address = mysqli_real_escape_string($con, $_POST["address"]);  // get the address input
    $postcode = mysqli_real_escape_string($con, $_POST["postcode"]);  // get the postcode input
    $dob = mysqli_real_escape_string($con, $_POST["dob"]);  // get the date of birth input

    // the SQL UPDATE query to update user details in the database
    $sql = "UPDATE register SET 
            fname='$fname', 
            lname='$lname', 
            email='$email', 
            phonenumber='$phonenumber', 
            address='$address', 
            postcode='$postcode', 
            dob='$dob'
            WHERE ID = '$id'";  // Update the user data where the ID matches

    // Execute the SQL query and check if it was successful
    if (mysqli_query($con, $sql)) {
        // If the update was successful, set a success message in the session and redirect to the profile page
        $_SESSION['success_message'] = "Profile updated successfully!";
        header("Location: profileuser.php");  // Redirect to the profile page after update
    } else {
        // If there's an error, display the error message
        echo "Error: " . mysqli_error($con);  // Display error message if the query fails
    }
}
?>


