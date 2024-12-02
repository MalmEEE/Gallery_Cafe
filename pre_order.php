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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $product = $_POST['product'];
    $quantity = $_POST['quantity'];
    $preOrderDate = $_POST['pre_order_date'];
    $preOrderTime = $_POST['pre_order_time'];
    $notes = $_POST['notes'];

    // Use prepared statements to prevent SQL injection
    $sql = "INSERT INTO pre_orders (name, email, phone, product, quantity, pre_order_date, pre_order_time, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    // Bind parameters
    $stmt->bind_param("ssssisss", $name, $email, $phone, $product, $quantity, $preOrderDate, $preOrderTime, $notes);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>alert('Pre-order submitted successfully!'); window.location.href = 'order_confirmation.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.location.href = 'pre_order.php';</script>";
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
