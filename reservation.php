<?php
//Establish a MYSQL Database Connection
$connection = mysqli_connect("localhost", "root", "", "cafe_db");
//Connection validation check
if(!$connection){
    die("Connection failed: " . mysqli_connect_error());
}

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$date = $_POST['date'];
$time = $_POST['time'];
$guests = $_POST['guests'];

$query = "INSERT INTO reservations(name, email, phone, date, time, guests) VALUES
('$name','$email','$phone','$date','$time','$guests')";

if(mysqli_query($connection, $query)){
    echo "Your reservation added sucessfully!";
} else {
 echo "Error: " . $query . "<br>" . mysqli_error($connection);
}

//Close the database connection
mysqli_close($connection);
?>