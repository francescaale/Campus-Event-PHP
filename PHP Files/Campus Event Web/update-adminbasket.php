<?php
session_start();  // Start the session to maintain the user's basket data

// Check if the action is to remove an item from the basket
if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == 'remove') {
    // Get the event id from the GET request
    $event_id = $_GET['id'];
    // Remove the item from the basket by unsetting it in the session
    unset($_SESSION['basket'][$event_id]);
    // Redirect the user back to the basket page after removing the item
    header('Location: admin-basket.php');
}

// Check if the request method is POST and the quantity array is set 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['quantity'])) {
    // Loop through each item in the quantity array
    foreach ($_POST['quantity'] as $id => $new_quantity) {
        // Ensure the quantity is greater than 0 before updating
        if ($new_quantity > 0) {
            // Update the quantity of the item in the basket session
            $_SESSION['basket'][$id]['quantity'] = $new_quantity;
        }
    }
    // After updating, redirect the user to the basket page
    header('Location: admin-basket.php');
}

// Clear the basket if the "clear" action is triggered
if (isset($_GET['action']) && $_GET['action'] == 'clear') {
    // Unset the entire basket session
    unset($_SESSION['basket']);
    // Redirect the user back to the basket page after clearing
    header('Location: admin-basket.php');
}
?>
