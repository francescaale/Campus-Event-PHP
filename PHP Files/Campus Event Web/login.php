<?php
// Include the connection file to establish a database connection
include 'connection.php';

// Start a session to manage user sessions
session_start();

// Check if the login form has been submitted
if (isset($_POST['submit'])) { // (lecture 5)

    // get input values
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = md5($_POST['password']);  // Hash the password using md5

    // Query the database to check if the email and password match any records
    $select = "SELECT * FROM register WHERE email = '$email' && password = '$password'";

    // Execute the query and get the result
    $result = mysqli_query($con, $select); //(lecture 3)

    // Check if there is any matching record (i.e., the login details are correct)
    if (mysqli_num_rows($result) > 0) { // (lecture 5)

        // Fetch the record as an associative array
        $row = mysqli_fetch_array($result); //(lecture 3)
  
        // Check the user type (either 'admin' or 'user')
        if ($row['user_type'] == 'admin') {
  
            // If user is an admin, set a session variable and redirect to the admin page
            $_SESSION['admin_name'] = $row['fname'];
            header('location: adminpage.php'); // Redirect to admin dashboard
  
        } elseif ($row['user_type'] == 'user') {
  
            // If user is a regular user, set a session variable and redirect to the user page
            $_SESSION['user_name'] = $row['fname'];
            header('location: userpage.php'); // Redirect to user dashboard
  
        }
       
    } else {
        // If no matching record found (incorrect email or password), display an error message
        $error[] = 'Incorrect email or password!';
    } 
}
?>


<!DOCTYPE html> <!-- Specifies the document type and version of HTML -->
<html lang="en"> <!-- document type and sets the language to English -->
    <head>
        <title>Log In</title> <!-- Title for the page -->
        <meta charset="utf-8">  <!-- Specifies the character encoding for the webpage -->
        <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Makes the page responsive -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- Link to Bootstrap CSS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> <!-- Link to Bootstrap JavaScript -->
        <link rel="stylesheet" href="style.css"> <!-- Link to a custom stylesheet -->
    </head>
<body>

<!-- Nav -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3 sticky-top "> <!-- black navigation with a sticky top-->
    <a class="navbar-brand" href="index.php"> <!--  linked to home page-->
        <img src="images/logo.png" alt="Campus Events Logo" width="110" height="50" class="d-inline-block align-top"> <!-- logo at the left top of the page -->
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
      <li class="nav-item text-center">  <!-- Home page link -->
        <a class="nav-link" href="index.php">Home</a>
      </li>
      <li class="nav-item text-center">  <!-- Events page link -->
        <a class="nav-link" href="events.php">Events</a>
      </li>
      <a class="navbar-item text-center" href="basket.php">  
        <img src="images/basket.jpg" alt="basket icon" width="50" height="50" > 
      </a>
      <a class="navbar-item text-center" href="login.php">  
        <img src="images/user.png" alt="user icon" width="47" height="42"> 
      </a>
    </ul>
  </div>  <!-- End of collapsible navbar -->
</nav>


<!-- Log In section -->
<div class="container mt-5"> <!--  main container for the form-->
    <h3 class="text-center">Log In</h3>
    
    <form action="" method="post">

    <?php
  // Check if the $error array is set (Incorrect email or password!)
  if (isset($error)) {

    // Loop through error message stored in the $error array
    foreach ($error as $error) {

      // Display error message inside a <div> element
      echo '<div>' . $error . '</div>';
          };
        };
      ?>


        <!-- Email with required attribute -->
        <div class="mb-3 mt-5"> 
            <label class="form-label">Email</label>
            <input type="email" name="email"class="form-control" id="email" placeholder="e.g. abc@gmail.com" name="email" required>
            <div class="invalid-feedback">Please fill out this field.</div>
        </div>

        <!-- Password field with required attribute -->
        <div class="mb-3 mt-4">
            <label class="form-label">Password:</label>
            <input type="password" class="form-control" id="password" placeholder="e.g. Man1#" name="password" required>
            <div class="invalid-feedback">Please fill out this field.</div>
        </div>

        
        <!-- Checkbox with required attribute -->
        <div class="form-check mb-5 mt-4">
            <input class="form-check-input" type="checkbox" id="myCheck" name="remember" required>
            <label class="form-check-label" for="myCheck">I agree with the terms.</label>
        </div>

        <!-- Log in or Register Button -->
        <button type="submit" name="submit" class="btn btn-primary">Log In</button>

        <br><br>
        
        <p>Don't have an account? <a class="text-dark text-decoration-underline" href="registration.php">Register Now</a></p>
    </form>
</div>



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


<!-- JS -->
<script src="script.js"></script>
</body>
</html>
