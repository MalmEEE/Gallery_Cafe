<?php
// Include the database connection file
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cafe_db";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the request method is POST (form submission)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Handle file upload for product image
    $image = $_FILES['image']['tmp_name'];
    $imgContent = addslashes(file_get_contents($image));

    // SQL query to insert the new product into the database
    $sql = "INSERT INTO products (name, description, price, image) VALUES ('$name', '$description', '$price', '$imgContent')";

    // Execute the query and check if it was successful
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Food added successfully!'); window.location.href = 'Managefoodadmin.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location.href = 'Managefoodadmin.php';</script>";
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Manage Food Dashboard</title>
    <link rel="stylesheet" href="">
    <script>
        // JavaScript function to validate the product form
        function validateProductForm() {
            var name = document.getElementById('name').value;
            var description = document.getElementById('description').value;
            var price = document.getElementById('price').value;
            var image = document.getElementById('image').value;

            if (name == "") {
                alert("Product name must be filled out");
                return false;
            }
            if (description == "") {
                alert("Product description must be filled out");
                return false;
            }
            if (price == "" || isNaN(price) || price <= 0) {
                alert("Valid product price must be filled out");
                return false;
            }

            if (image == "") {
                alert("Product image must be selected");
                return false;
            }
            return true;
        }
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        h3 {
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 10px;
            font-weight: bold;
        }
        input[type="text"], input[type="number"], input[type="file"], textarea {
            margin-top: 5px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            margin-top: 20px;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #004080;
        }
        .view-products {
            display: inline-block;
            margin-top: 20px;
            padding: 10px;
            background-color: #007bff;
            color: black;
            text-decoration: none;
            border-radius: 5px;
        }
        .view-products:hover {
            background-color: #e0a800;
        }
    </style>
</head>
<body>
    <h2>Admin Manage Food Dashboard</h2>
    <div class="container">
        <h3>Add New Food</h3>
        <form action="Managefoodadmin.php" method="post" enctype="multipart/form-data" onsubmit="return validateProductForm()">
            <label for="name">Food Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="description">Food Description:</label>
            <textarea id="description" name="description" required></textarea>
            <label for="price">Food Price:</label>
            <input type="number" step="0.01" id="price" name="price" required>
            <label for="image">Food Image:</label>
            <input type="file" id="image" name="image" accept="image/*" required>
            <button type="submit">Add Food</button>
        </form>
        <a class="view-products" href="admin.html">Back</a>
        <a class="view-products" href="Viewfood.php">View Available Products</a>
    </div>
</body>
</html>
