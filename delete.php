<?php
include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['username'])) {
        echo "You must be logged in to delete your account.";
        exit;
    }

    $username = $_SESSION['username'];
    
    // Sanitize username
    $username = mysqli_real_escape_string($conn, $username);

    $query = "DELETE FROM users WHERE username='$username'";
    if (mysqli_query($conn, $query)) {
        session_destroy();
        echo "success"; // Send success message back to the AJAX request
        exit;
    } else {
        echo mysqli_error($conn); // Send error message back to the AJAX request
    }
}
?>
