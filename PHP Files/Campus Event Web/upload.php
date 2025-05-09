<?php
include 'connection.php'; // Include the database connection file

// Check if the form is submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the uploaded file from the 'file' input
    $file = $_FILES['file'];

    // Check for any errors in file upload
    if ($file['error'] > 0) {
        die("Error uploading file: " . $file['error']); // If an error exists, stop and display the error
    }

    // Get file properties: name, size, type, and temporary file location
    $name = $file['name'];
    $size = $file['size'];
    $type = $file['type'];
    $tmp_name = $file['tmp_name']; // image lab

    // Validate file size (limit: 4MB)
    if ($size > 4 * 1024 * 1024) {
        die("Error: File size exceeds 4MB."); // Stop if the file size exceeds the limit
    }

    // Read the file's contents and convert them into binary format
    $image = addslashes(file_get_contents($tmp_name));

    // Insert the image binary data into the 'events' table in the database
    $sql = "INSERT INTO events ( image) VALUES ('$image')";
    
    // Execute the SQL query to insert the image into the database
    if (mysqli_query($con, $sql)) {
        echo "File uploaded successfully!"; // If the query is successful, notify the user
    } else {
        echo "Error: " . mysqli_error($con); // If the query fails, display the error
    }
}
?>

