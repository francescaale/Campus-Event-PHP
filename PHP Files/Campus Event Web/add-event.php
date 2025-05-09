<?php
include 'connection.php'; // Include the database connection file

session_start(); // Start the session (lecture 5)

// Check if the admin is logged in, if not, redirect to the login page
if (!isset($_SESSION['admin_name'])) {
    header('location:login.php'); // Redirect to login page
}

// Check if the form is submitted using POST method 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Use the correct database connection variable ($con)
    $title = mysqli_real_escape_string($con, $_POST['title']); // Escape special characters
    $date = $_POST['date']; // Get the event date from the form
    $location = mysqli_real_escape_string($con, $_POST['location']); // Escape special characters for location
    $price = floatval($_POST['price']); // Convert price to a float value to ensure it's a valid number
    $time = $_POST['time']; // Get the event time from the form
    $age = intval($_POST['age']); // Convert age to an integer to ensure it's a valid number
    $description = mysqli_real_escape_string($con, $_POST['description']); // Escape special characters for description
    $more_info = mysqli_real_escape_string($con, $_POST['more_info']); // Escape special characters for additional information

    // Handle image upload
    $image = $_FILES['image']['name']; // Get the image file name (extension lab image)
    $image_tmp = $_FILES['image']['tmp_name']; // Get the temporary file path
    $image_folder = "uploads/" . basename($image); // Set the target folder for storing the uploaded image https://forums.phpfreaks.com/topic/233421-how-do-i-include-a-resizing-script-to-my-existing-script/#comment-1200540

    // Define allowed image file types
    $allowed_types = ['image/jpeg', 'image/png', 'image/jpg']; // Allowed MIME types https://stackoverflow.com/questions/7495407/uploading-in-codeigniter-the-filetype-you-are-attempting-to-upload-is-not-allo
    $file_type = mime_content_type($image_tmp); // Get the actual type of the uploaded file 

    // Check if the uploaded file type is allowed 
    if (in_array($file_type, $allowed_types)) {
        // Move the uploaded file to the specified folder
        if (move_uploaded_file($image_tmp, $image_folder)) {
            // SQL query to insert event data into the database
            $query = "INSERT INTO admin_event (title, date, location, price, time, age, description, more_info, image)
                      VALUES ('$title', '$date', '$location', '$price', '$time', '$age', '$description', '$more_info', '$image_folder')";

            // Execute the query and check if the event was added successfully https://stackoverflow.com/questions/47100250/cannot-display-alert-in-php-mysql
            if (mysqli_query($con, $query)) {
                // Display success message and redirect to 'see-event.php' page
                echo "<script>alert('Event added successfully!'); window.location.href='see-event.php';</script>";
            } else {
                // Display an error message if the query fails
                echo "<script>alert('Error adding event: " . mysqli_error($con) . "');</script>";
            }
        }
    }
}
?>



<!DOCTYPE html> <!-- Specifies the document type and version of HTML -->
<html lang="en">  <!-- HTML language set to English -->
    <head>
        <title>Campus Events │ Add Event</title>  <!-- The title of the web page / browser tab-->
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
                <i id="darkModeIcon" class="fas fa-moon"></i> <!-- Default icon for moon dark mode-->
            </button>
        </div>
    </div>


    <!-- Add event form -->
    <div class="container mt-5">
        <h2 class="text-center">Add Event</h2>
        <form action="" method="post" enctype="multipart/form-data"> <!-- extension lab images -->
            <div class="mb-3">
                <label class="form-label">Title:</label>
                <input type="text" class="form-control" name="title" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Date:</label>
                <input type="date" class="form-control" name="date" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Location:</label>
                <input type="text" class="form-control" name="location" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Price (£):</label>
                <input type="number" class="form-control" name="price" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Time:</label>
                <input type="time" class="form-control" name="time" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Age Limit:</label>
                <input type="number" class="form-control" name="age" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description:</label>
                <textarea class="form-control" name="description" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">More Info:</label>
                <textarea class="form-control" name="more_info"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Event Image:</label>
                <input type="file" class="form-control" name="image" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Event</button>
        </form>
</div>


<!--Footer section -->
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