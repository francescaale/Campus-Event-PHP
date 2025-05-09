<?php
session_start(); // Start the session to manage the basket 

// Check if the action is to remove an item from the basket
if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == 'remove') {
    // Get the event ID from the URL 
    $event_id = $_GET['id'];

    // Ensure the event exists in the basket before removing it
    if (isset($_SESSION['basket'][$event_id])) {
        // Remove the item from the basket
        unset($_SESSION['basket'][$event_id]);
    }

    // Redirect the user back to the basket page
    header('Location: user-basket.php');
}

// Handle updating quantities for all items in the basket (POST request)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['quantity'])) {
    // Loop through each item in the quantity array 
    foreach ($_POST['quantity'] as $id => $new_quantity) {
        // Check if the new quantity is greater than 0 before updating it
        if ($new_quantity > 0) {
            // Update the item's quantity in the session
            $_SESSION['basket'][$id]['quantity'] = $new_quantity;
        } else {
            // If quantity is 0 or less, remove the item from the basket
            unset($_SESSION['basket'][$id]);
        }
    }

    // Redirect the user to the basket page after updating the quantities
    header('Location: user-basket.php');
}

// Clear the basket if the "clear" action is triggered
if (isset($_GET['action']) && $_GET['action'] == 'clear') {
    // Remove all items from the basket
    unset($_SESSION['basket']);

    // Redirect the user back to the basket page
    header('Location: user-basket.php');
}
?>


