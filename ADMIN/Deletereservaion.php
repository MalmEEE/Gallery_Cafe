<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cafe_db";
$id = $_GET['id']; // Get id from the URL

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to delete a record
$sql = "DELETE FROM reservations WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "Reservation deleted successfully";
    header('Location: Managereservation.php'); // Redirect to view page after deleting
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>
