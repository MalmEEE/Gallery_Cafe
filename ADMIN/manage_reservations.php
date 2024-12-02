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
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $guests = $_POST['guests'];

    if (empty($id)) {
        // Add new reservation
        $query = "INSERT INTO reservations (name, email, phone, date, time, guests) VALUES ('$name', '$email', '$phone', '$date', '$time', '$guests')";
    } else {
        // Update existing reservation
        $query = "UPDATE reservations SET name='$name', email='$email', phone='$phone', date='$date', time='$time', guests='$guests' WHERE id='$id'";
    }

    if (mysqli_query($connection, $query)) {
        echo "Success!";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connection);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete'])) {
    // Delete reservation
    $id = $_GET['id'];
    $query = "DELETE FROM reservations WHERE id='$id'";
    if (mysqli_query($connection, $query)) {
        echo "Success!";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connection);
    }
} else {
    // Fetch all reservations
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
