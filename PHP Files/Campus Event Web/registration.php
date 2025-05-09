<?php
// Include the database connection file 
include 'connection.php'; // database connection file

// Start a new session or resume the current session 
session_start(); // Start the session (lecture 5 session)

// Check if the form has been submitted (check if the 'submit' button is clicked)
if(isset($_POST['submit'])){ // Check if the form is submitted (lecture 5 login)
    
    // get form inputs
    $fname = mysqli_real_escape_string($con, $_POST['fname']); // First name
    $lname = mysqli_real_escape_string($con, $_POST['lname']); // Last name
    $address = mysqli_real_escape_string($con, $_POST['address']); // Address
    $postcode = mysqli_real_escape_string($con, $_POST['postcode']); // Postcode
    $phonenumber = mysqli_real_escape_string($con, $_POST['phonenumber']); // Phone number
    $dob = $_POST['dob']; // Date of birth
    $email = mysqli_real_escape_string($con, $_POST['email']); // Email address
    
    // Hash the password using MD5
    $password = md5($_POST['password']); // First password input
    $password2 = md5($_POST['password2']); // Second password input for confirmation https://laracasts.com/discuss/channels/code-review/how-to-create-md5-password-in-php-and-save-to-database

    // Get the user type (either 'admin' or 'user')
    $user_type = $_POST['user_type']; // Either admin or user

    // Check if the user with the same email already exists in the database
    $select = "SELECT * FROM register WHERE email = '$email' && password = '$password' ";
    $result = mysqli_query($con, $select); //(lecture 3)

    // If the user already exists, show an error message
    if(mysqli_num_rows($result) > 0){ // If user exists
       $error[] = 'User already exists!'; // User already registered with this email

    }else{

       // If the passwords don't match, show an error message
       if($password != $password2){ // Check if passwords match
          $error[] = 'Password not matched!'; // Password mismatch error

       }else{
          // Insert the new user data into the 'register' table in the database
          $insert = "INSERT INTO register (fname, lname, address, postcode, phonenumber, email, dob, password, user_type) 
          VALUES('$fname', '$lname', '$address', '$postcode', '$phonenumber', '$email', '$dob', '$password','$user_type')";
          
          // Execute the query to insert the data
          mysqli_query($con, $insert); // Execute the insert query

          // Redirect the user to the login page after successful registration
          header('location: login.php'); // Redirect to login page after successful registration
       }
    }
};
?>


<!DOCTYPE html> <!-- Specifies the document type and version of HTML -->
<html lang="en"> <!-- document type and sets the language to English -->
    <head>
        <title> Register </title> <!-- Title for the page -->
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

<!-- Register form -->
<div class="container mt-5">
    <a href="login.php"><img src="images/back.png" alt="back icon" style="height:30px;"></a> <!-- Back button that takes you back to login page -->
    <h3 class="text-center">Register</h3> <!-- title -->

    <form action="" method="post">

    <?php
   // Check if the $error variable is set
   if(isset($error)){ 
      // Loop through each error in the $error array
      foreach($error as $error){ 
         // Display each error inside a <div> at the top of the form
         echo '<div>'.$error.'</div>'; 
      };
   }; // End of error checking and display
?>


        <!-- First name with required attribute -->
        <div class="mb-3 mt-3">
            <label class="form-label">First Name</label>
            <input type="text" class="form-control" id="fname" placeholder="e.g. Francesca" name="fname" required>
            <div class="invalid-feedback">Please fill out this field.</div>
        </div>

        <!-- Last name with required attribute -->
        <div class="mb-3 mt-3">
            <label class="form-label">Last Name</label>
            <input type="text" class="form-control" id="lname" placeholder="e.g. Donea" name="lname" required>
            <div class="invalid-feedback">Please fill out this field.</div>
        </div>

        <!-- Address with required attribute -->
        <div class="mb-3 mt-3">
            <label class="form-label">Address</label>
            <input type="text" class="form-control" id="address" placeholder="e.g. 14 Avenue, Mansfield" name="address" required>
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
        </div>

        <!-- Postcode with required attribute -->
        <div class="mb-3 mt-3">
            <label class="form-label">Postcode</label>
            <input type="text" class="form-control" id="zip" placeholder="e.g. NG12 3AB" name="postcode" required>
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
        </div>
        
        <!-- Phone number with pattern validation -->
        <div class="mb-3">
            <label class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="phone" name="phonenumber" placeholder="e.g. +447345678912" 
                pattern="[+][0-9]{12}" title="Must have (+44) followed by 12 digits" required>
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please enter (+44) followed by 12 digits.</div>
        </div>

        <!-- Gender with required attribute / used codepen--> 
        <div class="mb-3 mt-3">
        <label class="form-label">Gender</label>
        <select class="form-control" name="sex" id="sex" required>

            <option value="" disabled selected>Select your sex</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>

          </select>
        </div>          

        <!-- Date of birth with required attribute -->
        <div class="mb-3 mt-3">
            <label class="form-label">Date of Birth</label>
            <input type="date" name="dob" class="form-control" id="date" required>
            <div class="invalid-feedback">Please fill out this field.</div>
        </div>
        
        <!-- Email with required attribute -->
        <div class="mb-3 mt-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" id="email" placeholder="e.g. abc@gmail.com" name="email" required>
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
        </div>

        <!-- Password field with required attribute -->
        <div class="mb-3 mt-3">
            <label class="form-label">Password:</label>
            <input type="password" class="form-control" id="password" placeholder="e.g. Man1#" name="password" required>
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
        </div>

        <!-- Password field with required attribute -->
        <div class="mb-3 mt-3">
            <label class="form-label">Confirm Password:</label>
            <input type="password" class="form-control" id="password2" placeholder="e.g. Man1#" name="password2" required>
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
        </div> 
        
        <!-- Admin/user with required attribute / used codepen--> 
        <div class="mb-3 mt-3">
        <label class="form-label">Type</label>
        <select class="form-control" name="user_type" id="user_type" required>

            <option value="" disabled selected>Select your type</option>
            <option value="user">User</option>
            <option value="admin">Admin</option>

          </select>
        </div>  

        <!-- Checkbox with required attribute -->
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="myCheck" name="remember" required>
            <label class="form-check-label" for="myCheck">I agree with the terms.</label>
        </div>

        <!-- Submit Button -->
        <button type="submit" name="submit" class="btn btn-primary">Register</button>
        
        <br><br>
        
        <p>Already have an account? <a class="text-dark text-decoration-underline" href="login.php">Login Now</a></p>
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
