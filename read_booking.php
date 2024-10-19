<?php
include 'config.php';
session_start();

// Fetch all bookings
$sql = "SELECT * FROM bookings ORDER BY safari_date ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings List - Wild Safari</title>
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
            width: 90%;
            margin: auto;
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white */
            padding: 20px;
            margin-top: 50px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .action-links a {
            text-decoration: none;
            padding: 8px 12px;
            color: white;
            border-radius: 5px;
            margin-right: 5px;
        }
        .edit {
            background-color: #007bff;
        }
        .delete {
            background-color: #dc3545;
        }
        .navigate-button {
            display: block;
            width: 100%;
            margin-top: 20px;
            padding: 10px;
            text-align: center;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
        }
        .navigate-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Wild Safari Bookings List</h1>

    <?php if ($result->num_rows > 0) { ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Safari Date</th>
                <th>Number of People</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>

            <?php while($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['customer_name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['safari_date']; ?></td>
                    <td><?php echo $row['num_people']; ?></td>
                    <td><?php echo $row['booking_status']; ?></td>
                    <td class="action-links">
                        <a href="update_booking.php?id=<?php echo $row['id']; ?>" class="edit">Edit</a>
                        <a href="delete_booking.php?id=<?php echo $row['id']; ?>" class="delete">Delete</a>
                    </td>
                </tr>
            <?php } ?>

        </table>
    <?php } else { ?>
        <p>No bookings found.</p>
    <?php } ?>

    <!-- Navigation button to user_index.html -->
    <a href="user_index.html" class="navigate-button">Back to Home</a>
</div>

</body>
</html>

<?php
$conn->close();
?>
