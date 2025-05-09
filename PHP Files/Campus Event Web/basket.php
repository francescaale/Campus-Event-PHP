<!DOCTYPE html> <!-- Specifies the document type and version of HTML -->
<html lang="en"> <!-- document type and sets the language to English -->
    <head>
        <title>Campus Events │ Events</title> <!-- Title for the page -->
        <meta charset="utf-8"> <!-- Specifies the character encoding for the webpage -->
        <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Makes the page responsive -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- Link to Bootstrap CSS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> <!-- Link to Bootstrap JavaScript -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> <!-- Link to FontAwesome for the icons to make the dark mode function-->
        <link rel="stylesheet" href="style.css"> <!-- Link to a custom stylesheet -->
    </head>
<body>

 <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3 sticky-top"> <!-- Bootstrap navbar with dark theme and sticky position --> <!-- navbar-expand-lg - large screens / horizontal nav and collapse into a toggleable menu on smaller screens.-->
    <a class="navbar-brand" href="index.php"> <!-- Navbar brand with a link to the homepage -->
        <img src="images/logo.png" alt="Campus Events Logo" width="110" height="50" class="d-inline-block align-top"> <!-- Logo -->
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"> 
     <!-- class="navbar-toggler": default styles for hamburger button 
    type="button": type as "button"
    data-bs-toggle="collapse": Tells to show or hide a specific collapsible element 
    data-bs-target="#navbarNav": it targets an element with id="navbarNav" (the collapsible menu).
    aria-controls="navbarNav": indicates that the button controls the element with the id="navbarNav".
    aria-expanded="false": initially set to false (collapsed) and dynamically updates to true when the menu is expanded.
    aria-label="Toggle navigation": A text label for screen readers, describing the button's purpose (to toggle the navigation menu).-->
    
    <!-- Hamburger menu button for smaller screens -->
      <span class="navbar-toggler-icon"></span> <!-- Icon for the toggler button -->
    </button>

    <div class="collapse navbar-collapse" id="navbarNav"> <!-- Collapsible content -->
        <ul class="navbar-nav ms-auto h4 gap-4"> <!-- Navigation links styled with Bootstrap -->
            <li class="nav-item text-center"><a class="nav-link" href="index.php">Home</a></li> <!-- Home link -->
            <li class="nav-item text-center"><a class="nav-link" href="events.php">Events</a></li> <!-- Events link -->
            <a class="navbar-item text-center" href="basket.php">  
        <img src="images/basket.jpg" alt="basket icon" width="50" height="50" > 
      </a>
      <a class="navbar-item text-center" href="login.php">  
        <img src="images/user.png" alt="user icon" width="47" height="42"> 
      </a>
        </ul>
    </div>
</nav>


<!-- Dark Mode Button -->
<div class="container-fluid mt-3">
    <div class="d-flex justify-content-end"> <!-- Align button to the right -->
        <button id="darkModeButton" class="btn btn-dark" onclick="darkMode()"> <!-- Button for toggling dark mode -->
            <i id="darkModeIcon" class="fas fa-moon"></i> <!-- Default icon for moon (dark mode) -->
        </button>
    </div>
</div>


<!-- Basket Section -->
<section class="container text-center">
<img src="images/basket.jpg" alt="basket icon" width="200" height="200"> 
    <h2 class="text-center mb-4">Your basket is empty</h2>
    <a href="login.php" class="btn btn-primary">Log In</a>
        <br><br>  
    <p>Don't have an account? <a class="text-dark text-decoration-underline" href="registration.php">Register Now</a></p>
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
               <a href="index.php" class="text-white me-3"><strong>Home</strong></a>  <!-- Home link -->
               <a href="events.php" class="text-white me-3"><strong>Events</strong></a>  <!-- Events link -->
               <a href="basket.php" class="text-white me-3"><strong>Basket</strong></a>  <!-- Basket link -->
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