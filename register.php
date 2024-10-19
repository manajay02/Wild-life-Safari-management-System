<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if the username or email already exists
    $check_user_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($conn, $check_user_query);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Username or email already exists.')</script>";
    } else {
        $query = "INSERT INTO users (username, email, password, gender, age, phone) 
                  VALUES ('$username', '$email', '$hashed_password', '$gender', '$age', '$phone')";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Registration successful!'); window.location.href='login.php';</script>";
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <style>
        /* Body and Background */
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/background.jpg'); /* Path to your background image */
            background-size: cover; /* Cover the entire screen */
            background-position: center; /* Center the image */
            background-repeat: no-repeat; /* No repeat */
            height: 100vh; /* Ensure it covers full viewport */
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        /* Form Container */
        .container {
            background: rgba(255, 255, 255, 0.8); /* Semi-transparent white */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        input:focus, select:focus {
            border-color: #00b4d8;
            outline: none;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #00b4d8;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0077b6;
        }

        .error {
            color: red;
            font-size: 12px;
            margin-top: -10px;
            margin-bottom: 10px;
        }
    </style>
    <script>
        function validateForm() {
            let username = document.getElementById('username').value;
            let email = document.getElementById('email').value;
            let password = document.getElementById('password').value;
            let age = document.getElementById('age').value;
            let phone = document.getElementById('phone').value;

            let emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            let phonePattern = /^\d{10}$/;

            let valid = true;

            if (username === "") {
                document.getElementById('usernameError').textContent = "Username is required";
                valid = false;
            } else {
                document.getElementById('usernameError').textContent = "";
            }

            if (!emailPattern.test(email)) {
                document.getElementById('emailError').textContent = "Invalid email format";
                valid = false;
            } else {
                document.getElementById('emailError').textContent = "";
            }

            if (password === "" || password.length < 6) {
                document.getElementById('passwordError').textContent = "Password must be at least 6 characters";
                valid = false;
            } else {
                document.getElementById('passwordError').textContent = "";
            }

            if (age === "" || isNaN(age) || age <= 0) {
                document.getElementById('ageError').textContent = "Please enter a valid age";
                valid = false;
            } else {
                document.getElementById('ageError').textContent = "";
            }

            if (!phonePattern.test(phone)) {
                document.getElementById('phoneError').textContent = "Phone number must be 10 digits";
                valid = false;
            } else {
                document.getElementById('phoneError').textContent = "";
            }

            return valid;
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form method="POST" action="" onsubmit="return validateForm()">
            <label>Username:</label>
            <input type="text" id="username" name="username">
            <span id="usernameError" class="error"></span>

            <label>Email:</label>
            <input type="email" id="email" name="email">
            <span id="emailError" class="error"></span>

            <label>Password:</label>
            <input type="password" id="password" name="password">
            <span id="passwordError" class="error"></span>

            <label>Gender:</label>
            <select name="gender" id="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>

            <label>Age:</label>
            <input type="number" id="age" name="age">
            <span id="ageError" class="error"></span>

            <label>Phone Number:</label>
            <input type="text" id="phone" name="phone">
            <span id="phoneError" class="error"></span>

            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
