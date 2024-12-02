<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

// Check if a username is provided in the query parameters
if (isset($_GET['username'])) {
    $username = $_GET['username'];
    // Define the SQL query to fetch the user details based on the provided username
    $sql = "SELECT * FROM users WHERE username='$username'";
    // Execute the query and get the result
    $result = mysqli_query($conn, $sql);

    // Check if the user exists
    if (mysqli_num_rows($result) > 0) {
        // Fetch the user details as an associative array
        $user = mysqli_fetch_assoc($result);
    } else {
        // If the user is not found, show an alert and redirect to the users page
        echo "<script>alert('User not found.'); window.location.href = 'Viewusers.php';</script>";
        exit(); // Stop further execution
    }
}

// Check if the form is submitted via POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the updated user details from the form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Define the SQL query to update the user
    $sql = "UPDATE users SET email='$email', password='$password', role='$role' WHERE username='$username'";

    // Execute the update query and check if it is successful
    if (mysqli_query($conn, $sql)) {
        // If successful, show an alert and redirect to the users page
        echo "<script>alert('User updated successfully!'); window.location.href = 'Viewusers.php';</script>";
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
    <title>Edit Users</title>
    <link rel="stylesheet" href="food.css">
</head>
<body>
    <div class="form-container">
        <h2>Edit Users</h2>
        <!-- Form for editing user details -->
        <form method="post">
            <!-- Input fields for the user details -->
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?php echo isset($user['username']) ? $user['username'] : ''; ?>" required readonly>

            <label for="email">Email</label>
            <input type="text" id="email" name="email" value="<?php echo isset($user['email']) ? $user['email'] : ''; ?>" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" value="<?php echo isset($user['password']) ? $user['password'] : ''; ?>" required>
            
            <label for="role">Role</label>
            <input type="text" id="role" name="role" value="<?php echo isset($user['role']) ? $user['role'] : ''; ?>" required>
            
            <button type="submit">Update User</button>
        </form>
        <!-- Link to cancel the edit and go back to the users page -->
        <a href="Viewusers.php">Cancel</a>
    </div>
</body>
</html>
