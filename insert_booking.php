<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = $_POST['customer_name'];
    $email = $_POST['email'];
    $safari_date = $_POST['safari_date'];
    $num_people = $_POST['num_people'];

    // Insert new booking
    $sql = "INSERT INTO bookings (customer_name, email, safari_date, num_people) 
            VALUES ('$customer_name', '$email', '$safari_date', '$num_people')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Booking successfully added!');
                window.location.href = 'read_booking.php';
              </script>";
        exit;
    } else {
        echo "<script>
                alert('Error: " . $conn->error . "');
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
    <title>Register Booking - Wild Safari</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/background.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: auto;
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent background */
            padding: 20px;
            margin-top: 50px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
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
        input[type="date"] {
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
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .message {
            text-align: center;
            margin-top: 20px;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
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
                alert("Booking successfully added!");
            }
        }
    </script>
</head>
<body>

<div class="container">
    <h1>Register Your Safari Booking</h1>

    <form action="insert_booking.php" method="POST" onsubmit="submitForm(event)">
        <label for="customer_name">Customer Name:</label>
        <input type="text" id="customer_name" name="customer_name" required>
        <div id="nameError" class="error-message">Customer name is required.</div>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <div id="emailError" class="error-message">Invalid email format.</div>

        <label for="safari_date">Safari Date:</label>
        <input type="date" id="safari_date" name="safari_date" required>
        <div id="dateError" class="error-message">Safari date is required.</div>

        <label for="num_people">Number of People:</label>
        <input type="number" id="num_people" name="num_people" required>
        <div id="peopleError" class="error-message">Number of people must be greater than 0.</div>

        <button type="submit">Submit Booking</button>
    </form>
</div>

</body>
</html>
