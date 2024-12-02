<?php
$servername = "localhost";
$username = "root"; // change if necessary
$password = ""; // change if necessary
$dbname = "cafe_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle update request
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $product = $_POST['product'];
    $quantity = $_POST['quantity'];
    $pre_order_date = $_POST['pre_order_date'];
    $pre_order_time = $_POST['pre_order_time'];

    $conn->query("UPDATE pre_orders SET name='$name', email='$email', phone='$phone', product='$product', quantity='$quantity', pre_order_date='$pre_order_date', pre_order_time='$pre_order_time' WHERE id=$id") or die($conn->error);

    header("Location: Managepreorders.php");
}

// Fetch the pre-order to edit
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM pre_orders WHERE id=$id") or die($conn->error);
    $row = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Pre-order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 500px;
            width: 100%;
            box-sizing: border-box;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        input {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            width: 100%;
        }
        button {
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #45a049;
        }
        .back-button {
            display: inline-block;
            text align:center;
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
    <div class="container">
        <h1>Edit Pre-order</h1>
        <form action="Editpreorder.php" method="post">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required>
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="<?php echo $row['phone']; ?>" required>
            <label for="product">Product:</label>
            <input type="text" id="product" name="product" value="<?php echo $row['product']; ?>" required>
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" value="<?php echo $row['quantity']; ?>" required>
            <label for="pre_order_date">Pre-order Date:</label>
            <input type="date" id="pre_order_date" name="pre_order_date" value="<?php echo $row['pre_order_date']; ?>" required>
            <label for="pre_order_time">Pre-order Time:</label>
            <input type="time" id="pre_order_time" name="pre_order_time" value="<?php echo $row['pre_order_time']; ?>" required>
            <button type="submit" name="update">Update</button>
            <a href="Managepreorders.php" class="back-button">Back to Manage Preorders</a>
        </form>
    </div>
</body>
</html>
