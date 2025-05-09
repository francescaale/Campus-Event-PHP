<?php
// Include the database connection file to interact with the database
include 'connection.php';

// Start the session (ensures we can access session variables)
session_start();

// Unset all session variables, essentially logging out the user
session_unset();

// Destroy the current session, effectively logging the user out
session_destroy();

// Redirect the user to the login page after successful logout
header('location:login.php'); 

// Lecture 5 - Authentication: This is part of the user logout process.
?>
