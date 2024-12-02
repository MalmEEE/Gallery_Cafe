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

// Define the SQL query to fetch all products
$sql = "SELECT id, name, description, price, image FROM products";

// Execute the query and store the result
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Foods</title>
    <link rel="stylesheet" href="food.css">
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
        a {
            display: inline-block;
            padding: 10px 15px;
            text-decoration: none;
            color: white;
            background-color:#007bff;
            border-radius: 5px;
            margin-top: 2px;
        }

        a:hover {
            background-color: #000000;
        }
    </style>
    <script>
        // Function to filter products based on search input
        function searchProducts() {
            var input = document.getElementById('searchInput'); // Get search input element
            var filter = input.value.toLowerCase(); // Convert input to lowercase for case-insensitive search
            var table = document.getElementById('productsTable'); // Get the table element
            var tr = table.getElementsByTagName('tr'); // Get all table rows

            // Loop through all table rows, starting from the second row (first row is the header)
            for (var i = 1; i < tr.length; i++) {
                tr[i].style.display = 'none'; // Hide row by default
                var td = tr[i].getElementsByTagName('td'); // Get all cells in the row
                
                // Loop through all cells in the row
                for (var j = 0; j < td.length; j++) {
                    if (td[j]) {
                        // If the cell contains the search term, display the row
                        if (td[j].innerHTML.toLowerCase().indexOf(filter) > -1) {
                            tr[i].style.display = '';
                            break;
                        }
                    }
                }
            }
        }
    </script>
</head>
<body>
    <div class="view-products-container">
        <h2>Available Foods</h2>
        <input type="text" id="searchInput" onkeyup="searchProducts()" placeholder="Search for products..">
        <table id="productsTable">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
            <?php
            // Check if there are results from the query
            if (mysqli_num_rows($result) > 0) {
                // Loop through each result and display in table rows
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['description'] . "</td>";
                    echo "<td>" . $row['price'] . "</td>";
                    // Display product image by encoding binary data to base64
                    echo '<td><img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" alt="Product Image"/></td>';
                    echo '<td>';
                    // Provide links for editing and deleting products
                    echo '<a href="Editfood.php?id=' . $row['id'] . '">Edit</a> | ';
                    echo '<a href="Deletefood.php?id=' . $row['id'] . '" onclick="return confirm(\'Are you sure you want to delete this product?\')">Delete</a>';
                    echo '</td>';
                    echo "</tr>";
                }
            } else {
                // If no results, display a message
                echo "<tr><td colspan='7'>No products found</td></tr>";
            }
            // Close the database connection
            mysqli_close($conn);
            ?>
        </table>
        <a href="Managefoodadmin.php">Back to Admin Dashboard</a>
    </div>
</body>
</html>
