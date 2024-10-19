<?php
include 'config.php';
session_start();

// Check if booking ID is passed in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the existing booking details
    $sql = "SELECT * FROM bookings WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $booking = $result->fetch_assoc();
    } else {
        echo "<script>
                alert('No booking found with ID $id.');
                window.location.href = 'read_booking.php';
              </script>";
        exit;
    }
}

// Handle form submission to update the booking
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $customer_name = $_POST['customer_name'];
    $email = $_POST['email'];
    $safari_date = $_POST['safari_date'];
    $num_people = $_POST['num_people'];
    $booking_status = $_POST['booking_status'];

    // Update the booking in the database
    $sql = "UPDATE bookings 
            SET customer_name = '$customer_name', 
                email = '$email', 
                safari_date = '$safari_date', 
                num_people = '$num_people', 
                booking_status = '$booking_status'
            WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Booking updated successfully!');
                window.location.href = 'read_booking.php';
              </script>";
        exit;
    } else {
        echo "<script>
                alert('Error updating booking: " . $conn->error . "');
              </script>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Booking - Wild Safari</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('images/background.jpg'); /* Replace with your actual image path */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .container {
            width: 50%;
            margin: auto;
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white */
            padding: 20px;
            margin-top: 50px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #333;
        }
        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: red;
            font-size: 0.9rem;
            display: none;
        }
    </style>
    <script>
        function validateForm() {
            let valid = true;

            const name = document.getElementById("customer_name");
            const email = document.getElementById("email");
            const date = document.getElementById("safari_date");
            const numPeople = document.getElementById("num_people");
            const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

            // Clear all error messages
            document.querySelectorAll(".error-message").forEach(error => error.style.display = 'none');
            
            if (name.value.trim() === "") {
                document.getElementById("nameError").style.display = 'block';
                valid = false;
            }
            if (!emailRegex.test(email.value)) {
                document.getElementById("emailError").style.display = 'block';
                valid = false;
            }
            if (date.value === "") {
                document.getElementById("dateError").style.display = 'block';
                valid = false;
            }
            if (numPeople.value <= 0) {
                document.getElementById("peopleError").style.display = 'block';
                valid = false;
            }

            return valid;
        }

        function submitForm(event) {
            if (!validateForm()) {
                event.preventDefault();
            } else {
                alert("Booking updated successfully!");
            }
        }
    </script>
</head>
<body>

<div class="container">
    <h1>Update Booking</h1>

    <form method="POST" action="update_booking.php" onsubmit="submitForm(event)">
        <input type="hidden" name="id" value="<?php echo $booking['id']; ?>">

        <label for="customer_name">Customer Name:</label>
        <input type="text" id="customer_name" name="customer_name" value="<?php echo $booking['customer_name']; ?>" required>
        <div id="nameError" class="error-message">Customer name is required.</div>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $booking['email']; ?>" required>
        <div id="emailError" class="error-message">Invalid email format.</div>

        <label for="safari_date">Safari Date:</label>
        <input type="date" id="safari_date" name="safari_date" value="<?php echo $booking['safari_date']; ?>" required>
        <div id="dateError" class="error-message">Safari date is required.</div>

        <label for="num_people">Number of People:</label>
        <input type="number" id="num_people" name="num_people" value="<?php echo $booking['num_people']; ?>" required>
        <div id="peopleError" class="error-message">Number of people must be greater than 0.</div>

        <label for="booking_status">Booking Status:</label>
        <select id="booking_status" name="booking_status">
            <option value="pending" <?php echo ($booking['booking_status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
            <option value="confirmed" <?php echo ($booking['booking_status'] == 'confirmed') ? 'selected' : ''; ?>>Confirmed</option>
            <option value="cancelled" <?php echo ($booking['booking_status'] == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
        </select>

        <button type="submit">Update Booking</button>
    </form>
</div>

</body>
</html>
