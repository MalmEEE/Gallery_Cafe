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
    // Retrieve the product ID from the query parameters
    $product_id = $_GET['id'];
    // Define the SQL query to delete the product with the specified ID
    $sql = "DELETE FROM products WHERE id='$product_id'";

    // Execute the delete query and check if it is successful
    if (mysqli_query($conn, $sql)) {
        // If successful, show an alert and redirect to the products page
        echo "<script>alert('Product deleted successfully!'); window.location.href = 'Viewfood.php';</script>";
    } else {
        // If there is an error, display the error message
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // If no product ID is provided, show an alert and redirect to the products page
    echo "<script>alert('Invalid product ID.'); window.location.href = 'Viewfood.php';</script>";
}

// Close the database connection
mysqli_close($conn);
?>
