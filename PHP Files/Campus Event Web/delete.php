<?php
// Include the database connection file to establish a connection
include 'connection.php';

// Start the session to access session variables
session_start();

// Check if the admin is logged in. If not, redirect to the login page
if (!isset($_SESSION['admin_name'])) {
    header('location:login.php');
}

// Get the event ID from the URL using GET method
$id = $_GET['id'];

// SQL query to delete the event from the admin_event table based on the event ID
$delete_query = "DELETE FROM admin_event WHERE id = '$id'";

// Execute the query
if (mysqli_query($con, $delete_query)) {
    // If the event is deleted successfully, display a success message and redirect to the 'see-event.php' page
    echo "<script>alert('Event deleted successfully!'); window.location.href='see-event.php';</script>";
} else {
    // If there is an error, display an error message with the details of the error
    echo "<script>alert('Error deleting event: " . mysqli_error($con) . "');</script>";
}
?>