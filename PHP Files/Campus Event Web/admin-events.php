<?php
include 'connection.php'; // Include the connection.php file to establish a connection to the database
session_start(); // Start the session to check for any session variables (lecture 5)

// Check if the session variable 'admin_name' is set, meaning the user is logged in as an admin
if (!isset($_SESSION['admin_name'])) {
    header('location:login.php'); // If not logged in, redirect to login page
}

// Query to select all events from the 'events' table
$sql = 'SELECT * FROM events'; 

// Execute the SQL query
$result = mysqli_query($con, $sql); //(lecture 3)

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


<!-- Events Section -->
<section class="container mt-5">
    <h2 class="text-center mb-4">All Events</h2>
    <div class="row"> 

    <?php
    // Loop through all events fetched from the database using the result from the query (lecture 3)
    while ($row = mysqli_fetch_assoc($result)) { 
        // Convert the image data from the database (BLOB) to base64 to display it as an image in HTML
        $imageData = base64_encode($row['image']); // Encode image data to base64 https://stackoverflow.com/questions/3967515/how-to-convert-an-image-to-base64-encoding
        $imageSrc = 'data:image/jpeg;base64,' . $imageData; // Create a base64 encoded image source string for embedding

        // Dynamically display the card with event data (title, date, and image)
        echo '
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="' . $imageSrc . '" class="card-img-top" alt="Event Image" style="height:276px;"> <!-- Event image -->
                <div class="card-body">
                    <h5 class="card-title">' . $row['title'] . '</h5> <!-- Event title -->
                    <p class="card-text">Date: ' . $row['date'] . '</p> <!-- Event date -->
                    <div class="d-flex justify-content-between align-items-center">
                        <!-- More Info button linking to event details -->
                        <a href="admin-event-details.php?id=' . $row['id'] . '" class="btn btn-dark">More Info</a> 
                        <!-- Add to cart button linking to the basket -->
                        <a href="admin-basket.php?id=' . $row['id'] . '">
                            <img src="images/basket.jpg" alt="Add to Cart" style="width: 60px; height: 60px;">
                        </a>
                    </div>
                </div>
            </div>
        </div>';  
    }
?>
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

