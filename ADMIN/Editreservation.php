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

$message = ""; // For displaying messages

// Fetch the existing reservation
if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($id)) {
    $sql = "SELECT * FROM reservations WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $email = $row['email'];
        $phone = $row['phone'];
        $date = $row['date'];
        $time = $row['time'];
        $guests = $row['guests'];
    } else {
        echo "No reservation found with that ID.";
        exit;
    }
}

// Update the reservation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $guests = $_POST['guests'];

    $updateSql = "UPDATE reservations SET name='$name', email='$email', phone='$phone', date='$date', time='$time', guests='$guests' WHERE id=$id";
    if ($conn->query($updateSql) === TRUE) {
        $message = "Record updated successfully";
        echo "<script>alert('$message'); window.location.href='Editreservation.php?id=$id';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Reservation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            padding: 20px;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 300px;
            margin: 50px auto;
        }
        input[type="text"], input[type="email"], input[type="date"], input[type="time"], input[type="number"] {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 2px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .back-button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <form method="post">
        <h2>Edit Reservation</h2>
        Name: <input type="text" name="name" value="<?php echo $name; ?>"><br>
        Email: <input type="email" name="email" value="<?php echo $email; ?>"><br>
        Phone: <input type="text" name="phone" value="<?php echo $phone; ?>"><br>
        Date: <input type="date" name="date" value="<?php echo $date; ?>"><br>
        Time: <input type="time" name="time" value="<?php echo $time; ?>"><br>
        Guests: <input type="number" name="guests" value="<?php echo $guests; ?>"><br>
        <input type="submit" value="Update Reservation">
        <a href="Managereservation.php" class="back-button">Back to Manage Reservation</a>
    </form>
</body>
</html>
