<?php
// Include the database connection file to establish a connection
include 'connection.php';

// Retrieve the event ID from the URL using the GET method 
$id = mysqli_real_escape_string($con, $_GET['id']); 

// make SQL query to fetch the event details from the database where the event ID matches
$sql = "SELECT * FROM events WHERE id = '$id'";  

// Execute the query and store the result in the $result variable
$result = mysqli_query($con, $sql); //(lecture 3)

// Fetch the row from the result set as an associative array 
$row = mysqli_fetch_assoc($result); //(lecture 3)
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
        <img src="images/logo.png" alt="Campus Events Logo" width="110" height="50">
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


<!-- Event details -->
<section class="container-fluid mt-5">
    <div class="row">
        <div class="col-md-12 text-center"> 
            <?php
            if ($row) {
                $imageData = base64_encode($row['image']);
                $imageSrc = 'data:image/jpeg;base64,' . $imageData;
                echo '<img src="' . $imageSrc . '" class="img-fluid w-75 w-md-100" style="max-height: 350px;" alt="Event Image"><br><br>';
            } else {
                echo '<p>No event found.</p>';
            }
            ?>
        </div>

        <div class="col-md-8 mx-auto">
            <?php 
            if ($row) { 
                echo '
                <div class="p-4 shadow-lg">
                    <h1 class="text-center mb-3"><strong>' . ($row['title']) . '</strong></h1>
                    <p class="text-center text-muted">' . ($row['date']) . '</p>

                    <div class="row text-center my-4">
                        <div class="col-md-4">
                            <p class="h5"><strong>Price</strong><br>£' . ($row['price']) . '</p>
                        </div>
                        <div class="col-md-4">
                            <p class="h5"><strong>Age</strong><br>' . ($row['age']) . '+</p>
                        </div>
                        <div class="col-md-4">
                            <p class="h5"><strong>Time</strong><br>' . ($row['time']) . '</p>
                        </div>
                    </div>

                    <div class="text-center my-4"> 
                        <p class="h5"><strong>About this Event</strong></p>
                        <p class="px-3">' . ($row['description']) . '</p>

                        <p class="h5"><strong>More Information</strong></p>
                        <p class="px-3">' . ($row['more_info']) . '</p>

                        <p class="h5"><strong>Location</strong></p>
                        <p class="px-3">' . ($row['location']) . '</p>
                    </div>

                    <div class="text-center mt-4">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d73112.2490003623!2d-1.2524620363299122!3d52.953994008459944!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x487832d2390779cd%3A0x108063201919db15!2sNottingham!5e1!3m2!1sen!2suk!4v1741599850097!5m2!1sen!2suk" class="w-100 w-md-50" height="250" style="border:0; border-radius:10px;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                    
                    <div class="text-center mt-4">
                    <a href="basket.php?id=' . $row['id'] . '" class="btn btn-primary w-30">
                        Add to Cart
                    </a>
                    </div>
                </div>';
            } else {
                echo '<p>No event details available.</p>';
            }
            ?>
        </div>
    </div>
</section>



<!-- Footer Section -->
<footer class="bg-dark text-white p-4 text-center mt-5">
    <div class="container">
        <p><strong>Address:</strong> 123 Campus Lane, NG123AB</p>
        <div class="contact-info mt-3">
            <strong>Contact Us:</strong> <a href="mailto:info@campusevents.com" class="text-white">info@campusevents.com</a><br>
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

<script src="script.js"></script>
</body>
</html>
