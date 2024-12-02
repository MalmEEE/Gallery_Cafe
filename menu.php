<?php
// Database connection settings
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #1e1e1e;
            color: #fff;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        h1 {
            color: #A0522D;
            margin-bottom: 30px;
        }
        #searchInput {
            width: 50%;
            padding: 12px 20px;
            margin-bottom: 30px;
            border: 1px solid #A0522D;
            border-radius: 25px;
            background-color: #333;
            color: #fff;
            font-size: 16px;
        }
        table {
            width: 90%;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: #2c2c2c;
            box-shadow: 0 2px 5px rgba(255, 255, 255, 0.1);
            overflow: hidden;
            border-radius: 10px;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #444;
        }
        th {
            background-color: #A0522D;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #3d3d3d;
        }
        tr:hover {
            background-color: #505050;
        }
        img {
            width: 100px;
            height: auto;
            border-radius: 5px;
            transition: transform 0.3s;
        }
        img:hover {
            transform: scale(1.1);
        }
        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #A0522D;
            color: #fff;
            text-decoration: none;
            border-radius: 25px;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .back-btn:hover {
            background-color: #8b4513;
        }
    </style>
</head>
<body>
<input type="text" id="searchInput" onkeyup="searchProducts()" placeholder="Search for products..">
    <h1>Menu</h1>
    <table id="productsTable">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Image</th>
        </tr>

        <?php
        // Fetch data from the database
        $sql = "SELECT id, name, description, price, image FROM products";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                // Convert BLOB data to base64 for displaying the image
                $imgData = base64_encode($row['image']);
                $src = 'data:image/jpeg;base64,'.$imgData;

                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['description']}</td>
                        <td>{$row['price']}</td>
                        <td><img src='{$src}' alt='Product Image'></td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No records found</td></tr>";
        }

        // Close the database connection
        $conn->close();
        ?>
    </table>
    <a href="index.html" class="back-btn">Back to page</a>
</body>
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
</html>
