<?php
include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $username;
        echo "<script>alert('Login successful! Redirecting...'); window.location.href='useraccount.php';</script>";
    } else {
        echo "<script>alert('Invalid credentials. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <style>
        /* Body and Background Styling */
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('images/background.jpg'); /* Path to your background image */
            background-size: cover; /* Ensures background covers the entire page */
            background-position: center; /* Centers the background */
            height: 100vh; /* Full viewport height */
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Login Form Styling */
        .login-container {
            background: rgba(255, 255, 255, 0.85); /* Semi-transparent white */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            width: 400px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        input:focus {
            border-color: #0077b6;
            outline: none;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #0077b6;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #00b4d8;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }

        /* Back to Main Menu Button */
        .back-menu {
            margin-top: 20px;
            text-align: center;
        }

        .back-menu a {
            text-decoration: none;
            color: #0077b6;
            font-weight: bold;
        }

        .back-menu a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 500px) {
            .login-container {
                width: 90%; /* Adjusts the container width for small screens */
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form method="POST" action="login.php">
            <label>Username:</label>
            <input type="text" name="username" required>
            
            <label>Password:</label>
            <input type="password" name="password" required>

            <button type="submit">Login</button>
        </form>

        <!-- Back to Main Menu Button -->
        <div class="back-menu">
            <a href="index.html">Back to Main Menu</a>
        </div>
    </div>
</body>
</html>
