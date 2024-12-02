<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

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
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $product = $_POST['product'];
    $quantity = $_POST['quantity'];
    $preOrderDate = $_POST['pre_order_date'];
    $preOrderTime = $_POST['pre_order_time'];
    $notes = $_POST['notes'];

    if (empty($id)) {
        // Add new order
        $sql = "INSERT INTO pre_orders (name, email, phone, product, quantity, pre_order_date, pre_order_time, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssisss", $name, $email, $phone, $product, $quantity, $preOrderDate, $preOrderTime, $notes);
    } else {
        // Update existing order
        $sql = "UPDATE pre_orders SET name=?, email=?, phone=?, product=?, quantity=?, pre_order_date=?, pre_order_time=?, notes=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssisssi", $name, $email, $phone, $product, $quantity, $preOrderDate, $preOrderTime, $notes, $id);
    }

    if ($stmt->execute()) {
        echo "Success!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete'])) {
    // Delete order
    $id = $_GET['id'];
    $sql = "DELETE FROM pre_orders WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Success!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    // Fetch all orders
    $sql = "SELECT * FROM pre_orders";
    $result = $conn->query($sql);
    $orders = [];

    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }

    echo json_encode($orders);
}

$conn->close();
?>
