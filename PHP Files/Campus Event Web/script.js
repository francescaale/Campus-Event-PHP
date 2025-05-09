// Function to toggle dark mode
function darkMode() {
    const body = document.body; // Get the body element of the page
    const button = document.getElementById("darkModeButton"); // Get the dark mode toggle button
    const icon = document.getElementById("darkModeIcon"); // Get the icon element for the button

    body.classList.toggle("dark-mode"); // Toggle the "dark-mode" class on the body

    const isDarkMode = body.classList.contains("dark-mode"); // Check if the dark mode class is active
    icon.className = isDarkMode ? "fa fa-sun" : "fa fa-moon"; // Update the icon based on the current mode
    button.className = isDarkMode ? "btn btn-light" : "btn btn-dark"; // Update the button class for styling
};




