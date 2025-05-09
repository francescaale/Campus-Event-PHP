<?php
    include 'connection.php';  // Include the database connection file. 
    session_start();  // Start the session to access session variables.

    // Check if the session variable 'admin_name' is not set, which means the user is not logged in as an admin.
    if (!isset($_SESSION['admin_name'])) {
        header('location:login.php');  // Redirect the user to the login page if not logged in.
    }

    // Fetch the admin's data based on the 'ID' passed via GET. If the ID is not set, default to an empty string.
    $id = $_GET["ID"] ?? "";  // The null coalescing operator checks if "ID" exists in the URL; if not, it returns an empty string.
    
    // SQL query to select the admin's data from the 'register' table where the 'ID' matches and the 'user_type' is 'admin'.
    $sql = "SELECT * FROM register WHERE ID = '$id' AND user_type = 'admin'";

    // Execute the query and store the result in the variable $result.
    $result = mysqli_query($con, $sql); //(lecture 3)

    // Fetch the associative array of the result.
    $row = mysqli_fetch_assoc($result); //(lecture 3)

    // If no matching admin is found, output an error message and stop the script.
    if (!$row) {
        echo "Admin not found!";  // Display a message if no admin with the given ID is found.
    }
?>


<!DOCTYPE html> <!-- Specifies the document type and version of HTML -->
<html lang="en">  <!-- HTML language set to English -->
    <head>
        <title>Campus Events │ Edit</title>  <!-- The title of the web page / browser tab-->
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

<!-- Profile section form -->
<div class="container mt-5">
    <h2 class="text-center">Edit Admin Profile</h2>
    <form action="adminSaveProfileUpdate.php" method="post" class="p-4 border rounded shadow">
    <!-- Hidden input to store the admin ID -->
    <input type="hidden" name="id" value="<?= $row['ID']; ?>">

    <!-- First Name input field -->
    <label>First Name:</label>
    <input type="text" name="fname" class="form-control" value="<?= htmlspecialchars($row['fname']); ?>" required><br>

    <!-- Last Name input field -->
    <label>Last Name:</label>
    <input type="text" name="lname" class="form-control" value="<?= htmlspecialchars($row['lname']); ?>" required><br>

    <!-- Email input field -->
    <label>Email:</label>
    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($row['email']); ?>" required><br>

    <!-- Phone Number input field -->
    <label>Phone Number:</label>
    <input type="text" name="phonenumber" class="form-control" value="<?= htmlspecialchars($row['phonenumber']); ?>" required><br>

    <!-- Address input field -->
    <label>Address:</label>
    <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($row['address']); ?>" required><br>

    <!-- Postcode input field -->
    <label>Postcode:</label>
    <input type="text" name="postcode" class="form-control" value="<?= htmlspecialchars($row['postcode']); ?>" required><br>

    <!-- Date of Birth input field -->
    <label>Date of Birth:</label>
    <input type="date" name="dob" class="form-control" value="<?= htmlspecialchars($row['dob']); ?>" required><br>

    <!-- Submit button to save changes -->
    <button type="submit" class="btn btn-success">Save Changes</button>

    <!-- Cancel button to go back to the profile page without saving -->
    <a href="profileadmin.php" class="btn btn-secondary">Cancel</a>
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

</body>
</html>

