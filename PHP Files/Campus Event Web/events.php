<?php
// Include the database connection file to establish a connection
include 'connection.php';

// Define the SQL query to select all records from the 'events' table
$sql = 'SELECT * FROM events';

// Execute the query and store the result in the $result variable
$result = mysqli_query($con, $sql); //(lecture 3)
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Campus Events │ Events</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3 sticky-top">
    <a class="navbar-brand" href="index.php">
        <img src="images/logo.png" alt="Campus Events Logo" width="110" height="50" class="d-inline-block align-top">
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto h4 gap-4">
            <li class="nav-item text-center"><a class="nav-link" href="index.php">Home</a></li>
            <li class="nav-item text-center"><a class="nav-link" href="events.php">Events</a></li>
            <a class="navbar-item text-center" href="basket.php">
                <img src="images/basket.jpg" alt="basket icon" width="50" height="50">
            </a>
            <a class="navbar-item text-center" href="login.php">
                <img src="images/user.png" alt="user icon" width="47" height="42">
            </a>
        </ul>
    </div>
</nav>

<!-- Dark Mode Button -->
<div class="container-fluid mt-3">
    <div class="d-flex justify-content-end">
        <button id="darkModeButton" class="btn btn-dark" onclick="darkMode()">
            <i id="darkModeIcon" class="fas fa-moon"></i>
        </button>
    </div>
</div>



<!-- Events Section -->
<section class="container mt-5">
    <h2 class="text-center mb-4">All Events</h2>
    <div class="row">

    <?php
// Loop through all events in the database (lecture 3)
while ($row = mysqli_fetch_assoc($result)) {
    // Convert the image data to Base64, with a fallback if no image exists
    if ($row['image']) {
        $imageData = base64_encode($row['image']); // Convert image data to base64
        $imageSrc = 'data:image/jpeg;base64,' . $imageData; // Embed image as a data URI https://stackoverflow.com/questions/3967515/how-to-convert-an-image-to-base64-encoding
    } else {
        $imageSrc = 'path/to/default-placeholder.jpg'; // Placeholder image if no image exists
    }

    // Display the card with event data dynamically
    echo '
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <img src="' . $imageSrc . '" class="card-img-top img-fluid" alt="Event Image - ' . ($row['title']) . '" style="height:276px;">
            <div class="card-body">
                <h5 class="card-title">' . ($row['title']) . '</h5>
                <p class="card-text">Date: ' . ($row['date']) . '</p>
                <a href="event-details.php?id=' . ($row['id']) . '" class="btn btn-dark">More Info</a>
                &nbsp; &nbsp; &nbsp;
            </div>
        </div>
    </div>';
}
?>
</div>
</section>

<!-- Footer Section -->
<footer class="bg-dark text-white p-4 text-center mt-5">
    <div class="container">
           <p><strong>Address:</strong> 123 Campus Lane, NG123AB</p>
           <div class="contact-info mt-3">
               <strong>Contact Us:</strong> <a href="mailto:info@campusevents.com" class="text-white">info@campusevents.com</a> <br>
               <strong>Phone:</strong> (123) 456-7890
           </div>

           <nav class="footer-nav mt-3">
               <a href="index.php" class="text-white me-3"><strong>Home</strong></a>
               <a href="events.php" class="text-white me-3"><strong>Events</strong></a>
               <a href="basket.php" class="text-white me-3"><strong>Basket</strong></a>
               <a href="login.php" class="text-white"><strong>Log Out</strong></a>
           </nav>
           <div class="social-media mt-3 d-flex justify-content-center">
            <a href="https://www.facebook.com/" class="me-3" target="_blank">
                <img src="images/facebook.png" alt="Facebook Logo" width="50" height="40">
            </a>
            <a href="https://www.instagram.com/" class="me-3" target="_blank">
                <img src="images/instagram.png" alt="Instagram Logo" width="50" height="40">
            </a>
            <a href="https://www.twitter.com/" target="_blank">
                <img src="images/twitter.png" alt="Twitter Logo" width="50" height="40">
            </a>
           </div>
           <p class="mt-3">&copy; 2024 Campus Events. All Rights Reserved.</p>
    </div>
</footer>

<!-- External JS File -->
<script src="script.js"></script>
</body>
</html>

