<?php
include 'config.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];

$query = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Account</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('images/background.jpg') no-repeat center center/cover; /* Check the path */
            height: 100vh; /* Full height */
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        /* Overlay for better text visibility */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5); /* Dark overlay */
        }

        .account-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
            position: relative;
            z-index: 1; /* Ensure the container is above the overlay */
        }

        h2 {
            color: #0077b6;
            margin-bottom: 20px;
        }

        p {
            color: #555;
            margin: 10px 0;
        }

        a, button {
            display: inline-block;
            margin: 10px 5px;
            padding: 10px 15px;
            background-color: #0077b6;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            border: none;
            cursor: pointer;
        }

        a:hover, button:hover {
            background-color: #00b4d8;
        }

        .delete-button {
            background-color: #e63946;
        }

        .delete-button:hover {
            background-color: #d62839;
        }

        .back-button {
            background-color: #38b000;
            margin-top: 20px;
        }

        .back-button:hover {
            background-color: #4caf50;
        }

        .back-menu-container {
            position: absolute;
            bottom: -70px; /* Adjust this if needed */
            left: 50%;
            transform: translateX(-50%);
        }
    </style>
    <script>
        function confirmLogout() {
            return confirm("Are you sure you want to logout?");
        }

        function deleteAccount() {
            if (confirm("Are you sure you want to delete your account?")) {
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "delete.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        const response = xhr.responseText;
                        if (response === "success") {
                            alert("Account deleted successfully.");
                            window.location.href = "register.php"; 
                        } else {
                            alert("Error deleting account: " + response);
                        }
                    }
                };
                xhr.send("username=" + encodeURIComponent("<?php echo $username; ?>"));
            }
        }
    </script>
</head>
<body>
    <div class="overlay"></div>
    <div class="account-container">
        <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?></h2>
        <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
        <p>Gender: <?php echo htmlspecialchars($user['gender']); ?></p>
        <p>Age: <?php echo htmlspecialchars($user['age']); ?></p>
        <p>Phone: <?php echo htmlspecialchars($user['phone']); ?></p>
        <a href="update.php">Update Account</a>
        <button class="delete-button" onclick="deleteAccount()">Delete Account</button>
        <a href="logout.php" onclick="return confirmLogout()">Logout</a>

        <!-- Back to Main Menu Button -->
        <div class="back-menu-container">
            <a href="user_index.html" class="back-button">Back to Main Menu</a>
        </div>
    </div>
</body>
</html>
