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

// Check if a product ID is provided in the query parameters
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    // Define the SQL query to fetch the product details based on the provided ID
    $sql = "SELECT * FROM products WHERE id='$product_id'";
    // Execute the query and get the result
    $result = mysqli_query($conn, $sql);

    // Check if the product exists
    if (mysqli_num_rows($result) > 0) {
        // Fetch the product details as an associative array
        $product = mysqli_fetch_assoc($result);
    } else {
        // If the product is not found, show an alert and redirect to the products page
        echo "<script>alert('Product not found.'); window.location.href = 'Viewfood.php';</script>";
        exit(); // Stop further execution
    }
}

// Check if the form is submitted via POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the updated product details from the form
    $product_id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Check if an image file is uploaded
    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
        // Read the image file content and escape it for database storage
        $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
        // Define the SQL query to update the product with the new image
        $sql = "UPDATE products SET name='$name', description='$description', price='$price', image='$image' WHERE id='$product_id'";
    } else {
        // Define the SQL query to update the product without changing the image
        $sql = "UPDATE products SET name='$name', description='$description', price='$price', WHERE id='$product_id'";
    }

    // Execute the update query and check if it is successful
    if (mysqli_query($conn, $sql)) {
        // If successful, show an alert and redirect to the products page
        echo "<script>alert('Food updated successfully!'); window.location.href = 'Viewfood.php';</script>";
    } else {
        // If there is an error, display the error message
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
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
    <title>Edit Foods</title>
    <link rel="stylesheet" href="food.css">
</head>
<body>
    <div class="form-container">
        <h2>Edit Foods</h2>
        <!-- Form for editing product details -->
        <form method="post" enctype="multipart/form-data">
            <!-- Hidden field to store the product ID -->
            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
            <!-- Input fields for the product details -->
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?php echo $product['name']; ?>" required>
            
            <label for="description">Description</label>
            <input type="text" id="description" name="description" value="<?php echo $product['description']; ?>" required>
            
            <label for="price">Price</label>
            <input type="number" id="price" name="price" value="<?php echo $product['price']; ?>" required>
              
            <label for="image">Image</label>
            <input type="file" id="image" name="image">
            
            <button type="submit">Update Food</button>
        </form>
        <!-- Link to cancel the edit and go back to the products page -->
        <a href="Viewfood.php">Cancel</a>
    </div>
</body>
</html>
