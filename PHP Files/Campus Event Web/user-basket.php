<?php
include 'connection.php'; // Include the database connection file
session_start(); // Start the session to access session variables

// Check if the user is logged in; if not, redirect to the login page
if (!isset($_SESSION['user_name'])) {
    header('location:login.php'); // Redirect to login page if user is not logged in
}

// Check if an event ID is passed by the URL
if (isset($_GET['id'])) {
    $event_id = $_GET['id']; // Get the event ID from the URL

    // Query to fetch event details from the database using the event ID
    $sql = "SELECT * FROM events WHERE id = '$event_id'";
    $result = mysqli_query($con, $sql); // Execute the query (lecture 3)
    $event = mysqli_fetch_assoc($result); // Fetch the event details (lecture 3)

    // Check if the event exists in the database
    if ($event) {
        // Store the event details in the session basket if event is found
        $_SESSION['basket'][$event_id] = [
            'title' => $event['title'],  // Store event title
            'price' => $event['price'],  // Store event price
            'quantity' => 1              // Set the initial quantity to 1
        ];
    }

    // Redirect back to the basket page
    header("Location: user-basket.php"); // Redirect user to the basket page
}
?>


<!DOCTYPE html> <!-- Specifies the document type and version of HTML -->
<html lang="en">  <!-- HTML language set to English -->
    <head>
        <title>Campus Events │ Basket</title>  <!-- The title of the web page / browser tab-->
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
    <a class="navbar-brand" href="userpage.php">  <!-- Navbar brand with a link to the homepage -->
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
        <a class="nav-link" href="userpage.php">Home</a>
      </li>
      <li class="nav-item text-center p-3">  <!-- Events page link -->
        <a class="nav-link" href="user-events.php">Events</a>
      </li>
      <a class="navbar-item text-center p-3" href="user-basket.php">  
        <img src="images/basket.jpg" alt="basket icon" width="50" height="50" > 
      </a>
      <a class="navbar-item text-center p-2" style="text-decoration:none;" href="profileuser.php">  
        <img src="images/user.png" alt="user icon" width="47" height="42"> 
        <br> <p class="text-center text-secondary h6"> <small><b><?php echo $_SESSION['user_name'] ?></b> </small></p>
      </a>
      <li class="nav-item text-center h6 p-4"> 
        <a class="nav-link" href="logout.php">Log Out</a>
      </li>
    </ul>
  </div>  <!-- End of collapsible navbar -->
</nav>  <!-- End of navigation bar -->


<!-- Dark Mode Button - https://fontawesome.com/icons/moon-over-sun?s=solid --> 
<div class="container-fluid mt-3">
    <div class="d-flex justify-content-end"> <!-- Align button to the right -->
        <button id="darkModeButton" title="darkmode" class="btn btn-dark" onclick="darkMode()"> <!-- Button for toggling dark mode -->
            <i id="darkModeIcon" class="fas fa-moon"></i> <!-- Default icon for moon (dark mode) -->
        </button>
    </div>
</div>

<!-- Basket section-->
<div class="container mt-5">
<?php
// Check if the basket is empty or not
if (!isset($_SESSION['basket']) || empty($_SESSION['basket'])) {
    // Display a message if the basket is empty
    echo "<h2>Your basket is empty.</h2><br>";
} else {
    // Start a form to update the basket with POST method
    echo '<form action="update-userbasket.php" method="post">';
    echo '<div class="row">';  // Start a row to display basket items

    $total_price = 0;  // Initialize total price of the items in the basket

    // Loop through all the items in the basket
    foreach ($_SESSION['basket'] as $id => $item) {
        // Calculate the total price for this item (price * quantity)
        $item_total = $item['price'] * $item['quantity'];
        $total_price += $item_total;  // Add the item total to the overall total price

        // Create a container for each basket item with a dark background
        echo '<div class="col-12 mb-4 bg-dark" style="padding: 15px; border-radius: 10px;">';
        echo '<div class="d-flex justify-content-between align-items-center">';  // Flex container to align content

        // Display event details (title, price, total for the item)
        echo '<div>';
        echo '<h5 class="text-white">' . $item['title'] . '</h5>';  
        echo '<p class="text-light"><strong>Price:</strong> £' . $item['price'] . '</p>';  
        echo '<p class="text-light"><strong>Total:</strong> £' . $item_total . '</p>';  
        echo '</div>';  // End event details section

        // Section to allow the user to modify the quantity of the item in the basket
        echo '<div class="d-flex align-items-center">';
        echo '<input type="number" title="quantity" name="quantity[' . $id . ']" value="' . $item['quantity'] . '" min="1" class="form-control" style="width: 60px; height: 30px; margin-right: 10px;">';  // Input field for quantity
        echo '<button type="submit" class="btn btn-primary btn-sm"> Add </button>';  // Submit button to update quantity
        echo '</div>';  // End quantity input section

        // Section to allow the user to remove the item from the basket
        echo '<div>';
        echo '<a href="update-userbasket.php?id=' . $id . '&action=remove" class="btn btn-danger btn-sm"> Remove </a>';  // Remove button to delete the item from the basket
        echo '</div>';

        echo '</div>';  // End the flex container for item details
        echo '</div>';  // End the container for the item
    }

    echo '</div>';  // Close the row

    // Display buttons to clear the basket and show the total price
    echo "<div class='text-end mt-2'>   
            <a href='update-userbasket.php?action=clear' class='btn btn-warning'>Clear Basket</a>  
            <div class='text-end mt-2 h4'>
                <strong>Total Price: £{$total_price}</strong>  
            </div>
          </div>";

    // Display a button to proceed to checkout
    echo "<div class='mt-4 text-end'>
            <a href='user-checkout.php' class='btn btn-success'>Proceed to Checkout</a>  
          </div>";

    echo '</form>';  // End the form
}
?>

    <div class="mt-4">
        <a href="user-events.php" class="btn btn-primary">Continue Looking</a>
    </div>
</div>




<br> <br><br>
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
               <a href="userpage.php" class="text-white me-3"><strong>Home</strong></a>  <!-- Home link -->
               <a href="user-events.php" class="text-white me-3"><strong>Events</strong></a>  <!-- Events link -->
               <a href="user-basket.php" class="text-white me-3"><strong>Basket</strong></a>  <!-- Basket link -->
               <a href="profileuser.php" class="text-white me-3"><strong>Profile</strong></a>  <!-- Profile link -->
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