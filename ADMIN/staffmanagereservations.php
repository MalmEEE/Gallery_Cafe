<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$connection = mysqli_connect("localhost", "root", "", "cafe_db");
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $status = $_POST['status'];

    $query = "UPDATE reservations SET status='$status' WHERE id='$id'";
    if (mysqli_query($connection, $query)) {
        echo "Success!";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connection);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM reservations WHERE id='$id'";
    $result = mysqli_query($connection, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode($row);
    } else {
        echo "Reservation not found.";
    }
} else {
    $query = "SELECT * FROM reservations";
    $result = mysqli_query($connection, $query);
    $reservations = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $reservations[] = $row;
    }
    echo json_encode($reservations);
}

mysqli_close($connection);
?>
