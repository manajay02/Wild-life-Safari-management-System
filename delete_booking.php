<?php
include 'config.php';
session_start();

// Check if the booking ID is passed in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // SQL query to delete the booking
    $sql = "DELETE FROM bookings WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Booking deleted successfully!');
                window.location.href = 'read_booking.php';
              </script>";
    } else {
        echo "<script>
                alert('Error deleting booking: " . $conn->error . "');
                window.location.href = 'read_booking.php';
              </script>";
    }
} else {
    echo "<script>
            alert('Invalid booking ID.');
            window.location.href = 'read_booking.php';
          </script>";
}

$conn->close();
?>
