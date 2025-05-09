<?php
// Include the connection file to connect to the database
include 'connection.php'; 

// Start the session to access session variables
session_start(); //(lecture 5)

// Check if the 'admin_name' session variable is not set, redirect to login page if not
if(!isset($_SESSION['admin_name'])){
    header('location:login.php');  // Redirects the user to the login page if they are not logged in
}

// get the 'id' from the URL 
$id = mysqli_real_escape_string($con, $_GET['id']); 

// Query to fetch event details based on the event ID
$sql = "SELECT * FROM events WHERE id = '$id'";  
// Execute the SQL query
$result = mysqli_query($con, $sql); //(lecture 3)

// Check if the 'id' is passed via the URL (this is to make sure the logic runs only when an ID is present)
if (isset($_GET['id'])) {
    // Store the event ID from the URL
    $event_id = $_GET['id'];

    // SQL query to fetch the event details based on the event ID
    $sql = "SELECT * FROM events WHERE id = '$event_id'";
    // Execute the query
    $result = mysqli_query($con, $sql); //(lecture 3)

    // Check if any result was returned from the query
    if (mysqli_num_rows($result) > 0) {
        // If results exist, fetch the data into the $row variable
        $row = mysqli_fetch_assoc($result); //(lecture 3)
    } else {
        // If no event was found with the given ID, set $row to null
        $row = null;  // This prevents warnings later if we try to use $row when no result is found
    }
}
?>


<!DOCTYPE html> <!-- Specifies the document type and version of HTML -->
<html lang="en">  <!-- HTML language set to English -->
    <head>
        <title>Campus Events │ Events</title>  <!-- The title of the web page / browser tab-->
        <meta charset="utf-8">  <!-- Specifies the character encoding for the webpage -->
        <meta name="viewport" content="width=device-width, initial-scale=1">  <!-- Ensures the page is responsive on different devices -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">  <!-- Link to Bootstrap CSS for styling -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>  <!-- Bootstrap JS for interactive components like the navbar -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="style.css">  <!-- Link to an external custom stylesheet -->
    </head>
<body>

<!-- Navigation Bar -->
 <nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3 sticky-top">  <!-- Bootstrap navbar with dark theme and sticky position --> <!-- navbar-expand-lg - large screens / horizontal nav and collapse into a toggleable menu on smaller screens.-->
    <a class="navbar-brand" href="adminpage.php">  <!-- Navbar brand with a link to the homepage -->
        <img src="images/logo.png" alt="Campus Events Logo" width="110" height="50" class="d-inline-block align-top">  <!-- Logo image with alt text and specified dimensions -->
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">  <!-- Button for toggling navbar on smaller screens -->
    <!-- class="navbar-toggler": default styles for hamburger button 
    type="button": type as "button"
    data-bs-toggle="collapse": Tells to show or hide a specific collapsible element 
    data-bs-target="#navbarNav": it targets an element with id="navbarNav" (the collapsible menu).
    aria-controls="navbarNav": indicates that the button controls the element with the id="navbarNav".
    aria-expanded="false": initially set to false (collapsed) and dynamically updates to true when the menu is expanded.
    aria-label="Toggle navigation": A text label for screen readers, describing the button's purpose (to toggle the navigation menu).-->

      <span class="navbar-toggler-icon"></span>  <!-- Icon for the toggler button -->
    </button>  <!-- End of navbar-toggler button -->

    <div class="collapse navbar-collapse " id="navbarNav">  <!-- Collapsible navbar for mobile responsiveness -->
    <ul class="navbar-nav ms-auto h4 gap-4">  <!-- Navigation list aligned to the right with spacing between items -->
      <li class="nav-item text-center p-3">  <!-- Home page link -->
        <a class="nav-link" href="adminpage.php">Home</a>
      </li>
      <li class="nav-item text-center p-3">  <!-- Events page link -->
        <a class="nav-link" href="admin-events.php">Events</a>
      </li>
      <a class="navbar-item text-center p-3" href="admin-basket.php">  
        <img src="images/basket.jpg" alt="basket icon" width="50" height="50" > 
      </a>
        <!-- Admin Profile Section with Dropdown -->
        <li class="nav-item dropdown text-center">
        <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="images/user.png" class="text-center " alt="admin icon" width="47" height="42"> 
            <br>
            <p class=" text-secondary h6  "><small><b><?php echo $_SESSION['admin_name']; ?></b></small></p>
        </a>
        <!-- Dropdown menu -->
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item text-center text-secondary h6" href="profileadmin.php">Profile</a></li>
            <li><a class="dropdown-item text-center text-secondary h6" href="add-event.php">Add event</a></li>
            <li><a class="dropdown-item text-center text-secondary h6" href="see-event.php">Your events</a></li>
        </ul>
        </li>

      <li class="nav-item text-center h6 p-4"> 
        <a class="nav-link" href="logout.php">Log Out</a>
      </li>
    </ul>
  </div>  <!-- End of collapsible navbar -->
</nav>  <!-- End of navigation bar -->


<!-- Dark Mode Button - https://fontawesome.com/icons/moon-over-sun?s=solid --> 
<div class="container-fluid mt-3">
    <div class="d-flex justify-content-end"> <!-- Align button to the right -->
        <button id="darkModeButton" class="btn btn-dark" onclick="darkMode()"> <!-- Button for toggling dark mode -->
            <i id="darkModeIcon" class="fas fa-moon"></i> <!-- Default icon for moon (dark mode) -->
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
                    <a href="admin-basket.php?id=' . $row['id'] . '" class="btn btn-primary w-30">
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
<footer class="bg-dark text-white p-4 text-center mt-5">  <!-- Footer with dark background, white text, and padding -->
    <div class="container">  <!-- Footer content container -->
           <p>
               <strong>Address:</strong> 123 Campus Lane, NG123AB  <!-- Address information -->
           </p>
           <div class="contact-info mt-3">  <!-- Contact information section -->
               <strong>Contact Us:</strong> <a href="mailto:info@campusevents.com" class="text-white">info@campusevents.com</a> <br>  <!-- Email contact link -->
               <strong>Phone:</strong> (123) 456-7890  <!-- Phone number -->
           </div>

           <nav class="footer-nav mt-3">  <!-- Footer navigation links -->
               <a href="adminpage.php" class="text-white me-3"><strong>Home</strong></a>  <!-- Home link -->
               <a href="admin-events.php" class="text-white me-3"><strong>Events</strong></a>  <!-- Events link -->
               <a href="admin-basket.php" class="text-white me-3"><strong>Basket</strong></a>  <!-- Basket link -->
               <a href="profileadmin.php" class="text-white me-3"><strong>Profile</strong></a>  <!-- Profile link -->
               <a href="login.php" class="text-white"><strong>Log Out</strong></a>  <!-- Log Out link -->
           </nav>
           <div class="social-media mt-3 d-flex justify-content-center">  <!-- Social media links section -->
            <a href="https://www.facebook.com/" class="me-3" target="_blank">  <!-- Facebook link -->
                <img src="images/facebook.png" alt="Facebook Logo" width="50" height="40">  <!-- Facebook logo image -->
            </a>
            <a href="https://www.instagram.com/" class="me-3" target="_blank">  <!-- Instagram link -->
                <img src="images/instagram.png" alt="Instagram Logo" width="50" height="40">  <!-- Instagram logo image -->
            </a>
            <a href="https://www.twitter.com/" target="_blank">  <!-- Twitter link -->
                <img src="images/twitter.png" alt="Twitter Logo" width="50" height="40">  <!-- Twitter logo image -->
            </a>
           </div>
           <p class="mt-3">&copy; 2024 Campus Events. All Rights Reserved.</p>  <!-- Copyright information -->
    </div> 
</footer>

<!-- External JS File -->
<script src="script.js"></script>  <!-- Link to my costume js file -->
</body>
</html>

