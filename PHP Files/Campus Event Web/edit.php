<?php
// Include the database connection file to establish a connection
include 'connection.php';

// Start the session to access session variables (admin login check)
session_start();

// Check if the admin is logged in. If not, redirect to the login page
if (!isset($_SESSION['admin_name'])) {
    header('location:login.php');
}

// Get the event ID from the URL using the GET method
$id = $_GET['id'];

// Fetch the event data from the database based on the event ID
$query = "SELECT * FROM admin_event WHERE id = '$id'";
$result = mysqli_query($con, $query); //(lecture 3)
$row = mysqli_fetch_assoc($result); //(lecture 3)

// If the form is submitted, update the event details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize the user inputs to prevent SQL injection
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $date = $_POST['date']; // No sanitization needed for date as it's plain text
    $location = mysqli_real_escape_string($con, $_POST['location']);
    $price = $_POST['price']; // Price can be a number
    $time = $_POST['time']; // Time is a string value
    $age = $_POST['age']; // Age is an integer
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $more_info = mysqli_real_escape_string($con, $_POST['more_info']);

    // Image upload handling 
    $image = $_FILES['image']['name']; // Get the uploaded image file name
    $image_tmp = $_FILES['image']['tmp_name']; // Get the temporary image file path
    $image_folder = "uploads/" . $image; // Specify where to store the uploaded image

    // If a new image is uploaded, move it to the 'uploads' directory
    if (move_uploaded_file($image_tmp, $image_folder)) {
        // Update query with the new image if uploaded
        $update_query = 
        "UPDATE admin_event SET title='$title', date='$date', location='$location', price='$price', time='$time', age='$age', description='$description', more_info='$more_info', image='$image_folder' 
        WHERE id='$id'";
    } else {
        // If no new image is uploaded, keep the old image and update other fields
        $update_query = 
        "UPDATE admin_event SET title='$title', date='$date', location='$location', price='$price', time='$time', age='$age', description='$description', more_info='$more_info' 
        WHERE id='$id'";
    }

    // Execute the update query
    if (mysqli_query($con, $update_query)) {
        // If the event was updated successfully, show a success message and redirect
        echo "<script>alert('Event updated successfully!'); window.location.href='see-event.php';</script>";
    } else {
        // If there's an error, show the error message
        echo "<script>alert('Error updating event: " . mysqli_error($con) . "');</script>";
    }
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


<!-- Edit event form -->
    <div class="container mt-5">
        <h2 class="text-center">Edit Event</h2>
        <form method="POST" enctype="multipart/form-data">
    <!-- Title Input Field -->
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title" value="<?php echo $row['title']; ?>" required>
    </div>

    <!-- Date Input Field -->
    <div class="mb-3">
        <label for="date" class="form-label">Date</label>
        <input type="date" class="form-control" id="date" name="date" value="<?php echo $row['date']; ?>" required>
    </div>

    <!-- Location Input Field -->
    <div class="mb-3">
        <label for="location" class="form-label">Location</label>
        <input type="text" class="form-control" id="location" name="location" value="<?php echo $row['location']; ?>" required>
    </div>

    <!-- Price Input Field -->
    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="number" class="form-control" id="price" name="price" value="<?php echo $row['price']; ?>" required>
    </div>

    <!-- Time Input Field -->
    <div class="mb-3">
        <label for="time" class="form-label">Time</label>
        <input type="time" class="form-control" id="time" name="time" value="<?php echo $row['time']; ?>" required>
    </div>

    <!-- Age Limit Input Field -->
    <div class="mb-3">
        <label for="age" class="form-label">Age Limit</label>
        <input type="number" class="form-control" id="age" name="age" value="<?php echo $row['age']; ?>" required>
    </div>

    <!-- Description Input Field -->
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $row['description']; ?></textarea>
    </div>

    <!-- More Info Input Field -->
    <div class="mb-3">
        <label for="more_info" class="form-label">More Info</label>
        <textarea class="form-control" id="more_info" name="more_info" rows="3" required><?php echo $row['more_info']; ?></textarea>
    </div>

    <!-- Image Input Field (Optional, for image upload) -->
    <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" class="form-control" id="image" name="image">
    </div>

    <!-- Submit Button -->
    <button type="submit" class="btn btn-primary">Update Event</button>
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
