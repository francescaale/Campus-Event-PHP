<?php
    include 'connection.php';  // Include the connection.php file to connect to the database. 
    session_start();  // Start a new session or resume the existing one for the current user. (lecture 5)

    // Check if the session variable 'admin_name' is not set, which means the user is not logged in as an admin.
    if (!isset($_SESSION['admin_name'])) {
        header('location:login.php');  // Redirect the user to the login page if they are not logged in.
    }
?>  


<!DOCTYPE html> <!-- Specifies the document type and version of HTML -->
<html lang="en">  <!-- HTML language set to English -->
    <head>
        <title>Campus Events │ Home Page</title>  <!-- The title of the web page / browser tab-->
        <meta charset="utf-8">  <!-- Specifies the character encoding for the webpage -->
        <meta name="viewport" content="width=device-width, initial-scale=1">  <!-- Ensures the page is responsive on different devices -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">  <!-- Link to Bootstrap CSS for styling -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>  <!-- Bootstrap JS for interactive components like the navbar -->
        <link rel="stylesheet" href="style.css">  <!-- Link to an external custom stylesheet -->
    </head>
    <style>
/* Cookies  https://www.w3schools.com/howto/howto_js_callout.asp */
.callout {
  background-color: #333;
  color: white;
  border: 1px solid #555;
  padding: 20px;
  position: fixed;
  bottom: 20px;
  right: 20px; /* Moves it to the far right */
  width: 320px;
  z-index: 1000;
  text-align: center;
  display: none; /* Hidden initially */
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.3);
  border-radius: 10px;
}

  .callout-header {
    font-weight: bold;
    margin-bottom: 10px;
  }

  .closebtn {
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
    font-size: 20px;
  }

  .callout-container {
    margin-top: 10px;
  }

  .accept-btn, .decline-btn {
    margin-top: 10px;
    padding: 10px 15px;
    cursor: pointer;
    font-size: 14px;
    border: none;
    border-radius: 5px;
    width: 100px;
  }

  .accept-btn {
    background-color: green;
    color: white;
  }

  .decline-btn {
    background-color: red;
    color: white;
    margin-left: 10px;
  }

  .accept-btn:hover, .decline-btn:hover {
    opacity: 0.8;
  }
</style>

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

    <div class="collapse navbar-collapse" id="navbarNav">  <!-- Collapsible navbar for mobile responsiveness -->
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
      <p class="nav-item text-center text-secondary p-3 h6"> <b>Welcome,<br> <?php echo $_SESSION['admin_name'] ?> </b></p>

      <!-- Admin Profile Section with Dropdown -->
    <li class="nav-item dropdown text-center">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="images/user.png" class="text-center " alt="admin icon" width="47" height="42"> 
            <br>
            <p class=" text-secondary h6"><small><b>admin</b></small></p>
        </a>
        <!-- Dropdown menu -->
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item text-center text-secondary h6" href="profileadmin.php">Profile</a></li>
            <li><a class="dropdown-item text-center text-secondary h6" href="add-event.php">Add event</a></li>
            <li><a class="dropdown-item text-center text-secondary h6" href="see-event.php">Your events</a></li>
        </ul>
    </li>

      <li class="nav-item h6 p-4"> 
        <a class="nav-link" href="logout.php">Log Out</a>
      </li>
    </ul>
  </div>  <!-- End of collapsible navbar -->
  </nav>  <!-- End of navigation bar -->

   <!-- Cookies https://www.w3schools.com/howto/howto_js_callout.asp  -->
  <div class="callout" id="cookieBanner">
  <div class="callout-header">Cookies</div>
  <span class="closebtn" onclick="hideBanner()">x</span>
  <div class="callout-container">
    <p>By using this site, you agree to our use of cookies. <u><a href="https://www.gov.uk/help/cookies" target="_blank">Learn more</a></u></p>
    <button class="accept-btn" onclick="acceptCookies()">Accept</button>
    <button class="decline-btn" onclick="declineCookies()">Decline</button>
  </div>
</div>


<!-- Carousel Section -->
<div class="container-fluid p-0">  <!-- Full-width container for the carousel -->
    <div id="demo" class="carousel slide" data-bs-ride="carousel">  <!-- Carousel with auto-slide functionality -->
        <!-- Indicators/dots for navigation -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>  <!-- First carousel indicator -->
            <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>  <!-- Second carousel indicator -->
            <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>  <!-- Third carousel indicator -->
        </div>
        <!-- data-bs-target="#demo": Specifies the target carousel to control. The value (#demo) matches the id of the carousel (<div id="demo" class="carousel slide">).
            data-bs-slide-to="n": Indicates the index of the slide the button corresponds to:
            data-bs-slide-to="0": First slide.
            data-bs-slide-to="1": Second slide.
            data-bs-slide-to="2": Third slide.
            class="active" (only for the first button): Indicates the current active slide (index 0).-->
        
        <!-- The slideshow/carousel -->
        <div class="carousel-inner">
            <div class="carousel-item active">  <!-- First carousel item (active) -->
                <img src="images/music_festival.jpg" alt=" an image of a music festival " class="d-block w-100" style="height: 650px;">  <!-- Image for the first carousel item -->
                <div class="carousel-caption">  <!-- Caption for the carousel item -->
                    <h2>Music Festival</h2>  <!-- Title of the carousel item -->
                    <p>Join us for an unforgettable music experience!</p>  <!-- Description of the carousel item -->
                    <a href="admin-events.php" class="btn btn-dark">Learn More</a>  <!-- Button link to the events page -->
                </div>
            </div>
            <div class="carousel-item">  <!-- Second carousel item -->
                <img src="images/theatre.jpg" alt="Theatre image" class="d-block w-100" style="height: 650px;">  <!-- Image for the second carousel item -->
                <div class="carousel-caption">
                    <h2>Theatre Performance</h2>
                    <p>Experience the magic of live theatre.</p>
                    <a href="admin-events.php" class="btn btn-dark">Learn More</a>
                </div>
            </div>
            <div class="carousel-item">  <!-- Third carousel item -->
                <img src="images/coding.jpg" alt="Code showing on a screen zoomed in" class="d-block w-100" style="height: 650px;">  <!-- Image for the third carousel item -->
                <div class="carousel-caption">
                    <h2>Coding Workshop</h2>
                    <p>Enhance your coding skills with our workshop.</p>
                    <a href="admin-events.php" class="btn btn-dark">Learn More</a>
                </div>
            </div>
        </div>
        
        <!-- Left and right controls/icons for carousel -->
        <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>  <!-- Icon for the previous button -->
            <span class="visually-hidden">Previous</span>  <!-- Screen reader text for accessibility -->
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>  <!-- Icon for the next button -->
            <span class=" visually-hidden">Next</span>  <!-- Screen reader text for accessibility -->
        </button>
        <!--    class="carousel-control-prev" (for the left button)
                class="carousel-control-next" (for the right button)
                type="button": these are button elements
                data-bs-target="#demo": specifies the target carousel to control
                data-bs-slide="prev" / data-bs-slide="next": Defines the direction of movement:
               - data-bs-slide="prev": Moves to the previous slide.
               - data-bs-slide="next": Moves to the next slide.
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>: adds a left arrow icon for the previous button using Bootstrap's built-in styles. The aria-hidden="true" hides the icon from screen readers since it's decorative.
                <span class="carousel-control-next-icon" aria-hidden="true"></span>: adds a right arrow icon for the next button using Bootstrap's built-in styles. Also uses aria-hidden="true" for accessibility.
                <span class="visually-hidden">Previous</span>: provides a description ("Previous") for screen readers to enhance accessibility.
                <span class="visually-hidden">Next</span>: provides a description ("Next") for screen readers. -->
    </div>
</div>


<!-- Footer Section -->
<footer class="bg-dark text-white p-4 text-center">  <!-- Footer with dark background, white text, and padding -->
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

<script>
//https://stackoverflow.com/questions/74566751/keep-cookie-consent-banner-hidden-once-users-accepted-cookies
  function acceptCookies() {
    hideBanner();
    console.log("Cookies Accepted");
  }

  function declineCookies() {
    hideBanner();
    console.log("Cookies Declined");
  }

  function hideBanner() {
    document.getElementById("cookieBanner").style.display = "none";
  }

  // Always show the banner on page load
  window.onload = function() {
    document.getElementById("cookieBanner").style.display = "block";
  };

</script>

<!-- External JS File -->
<script src="script.js"></script>  <!-- Link to my costume js file -->
</body>
</html>

