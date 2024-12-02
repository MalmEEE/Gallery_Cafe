<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reservations</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            padding: 20px;
        }
        h2 {
            color: #0056b3;
            font-size: 40px;
            text-align: center;
            margin-bottom: 40px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
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
<h2>Manage Reservations</h2>
    <?php
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

    $sql = "SELECT id, name, email, phone, date, time, guests FROM reservations";
    $result = $conn->query($sql);

    echo "<table><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Date</th><th>Time</th><th>Guests</th><th>Edit</th><th>Delete</th></tr>";
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["id"]. "</td><td>" . $row["name"]. "</td><td>" . $row["email"]. "</td><td>" . $row["phone"]. "</td><td>" . $row["date"]. "</td><td>" . $row["time"]. "</td><td>" . $row["guests"]. "</td>";
            echo "<td><a href='Editreservation.php?id=" . $row["id"] . "'>Edit</a></td>";
            echo "<td><a href='Deletereservaion.php?id=" . $row["id"] . "' onclick='return confirm(\"Are you sure you want to delete this reservation?\")'>Delete</a></td></tr>";
        }
    } else {
        echo "0 results";
    }
    echo "</table>";
    $conn->close();
    ?>
    <a href="admin.html" class="back-button">Back to Dashboard</a>
</body>
</html>
