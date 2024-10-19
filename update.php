<?php
include 'config.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $new_age = mysqli_real_escape_string($conn, $_POST['age']);
    $new_phone = mysqli_real_escape_string($conn, $_POST['phone']);
    
    $query = "UPDATE users 
              SET email='$new_email', gender='$new_gender', age='$new_age', phone='$new_phone' 
              WHERE username='$username'";
              
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Account updated successfully!'); window.location.href='useraccount.php';</script>";
    } else {
        echo "<script>alert('Error updating account: " . mysqli_error($conn) . "');</script>";
    }
}

$query = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Account</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            margin: 0;
        }

        .update-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        h2 {
            color: #0077b6;
            margin-bottom: 20px;
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
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #00b4d8;
        }
    </style>
    <script>
        function confirmUpdate() {
            return confirm("Are you sure you want to update your account?");
        }
    </script>
</head>
<body>
    <div class="update-container">
        <h2>Update Account</h2>
        <form method="POST" action="update.php" onsubmit="return confirmUpdate()">
            <label>New Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label>Gender:</label>
            <select name="gender">
                <option value="Male" <?php if($user['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if($user['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                <option value="Other" <?php if($user['gender'] == 'Other') echo 'selected'; ?>>Other</option>
            </select>

            <label>Age:</label>
            <input type="number" name="age" value="<?php echo htmlspecialchars($user['age']); ?>" required>

            <label>Phone Number:</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>

            <button type="submit">Update Account</button>
        </form>
    </div>
</body>
</html>
