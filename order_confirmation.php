<?php

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cafe_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the last inserted pre-order details
$sql = "SELECT * FROM pre_orders ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "<script>alert('No pre-order found!'); window.location.href = 'pre_order.php';</script>";
    exit();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container-c {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .container h1 {
            text-align: center;
            color: #333;
        }
        .order-details {
            margin-top: 20px;
        }
        .order-details p {
            line-height: 1.6;
        }
        .order-details span {
            font-weight: bold;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #CD5C5C;
            color: #fff;
            text-align: center;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-size: 16px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container-c">
        <h1>Order Confirmation</h1>
        <div class="order-details">
            <p><span>Name:</span> <?php echo $row['name']; ?></p>
            <p><span>Email:</span> <?php echo $row['email']; ?></p>
            <p><span>Phone:</span> <?php echo $row['phone']; ?></p>
            <p><span>Product:</span> <?php echo $row['product']; ?></p>
            <p><span>Quantity:</span> <?php echo $row['quantity']; ?></p>
            <p><span>Pre-Order Date:</span> <?php echo $row['pre_order_date']; ?></p>
            <p><span>Pre-Order Time:</span> <?php echo $row['pre_order_time']; ?></p>
            <p><span>Notes:</span> <?php echo $row['notes']; ?></p>
        </div>
        <a href="index.html" class="btn">Return to Home</a>
    </div>
</body>
</html>
