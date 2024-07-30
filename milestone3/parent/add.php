<?php
include("../functions.php");
$conn = connectToDatabase();

// Extract data from the $data array
$name = $_POST['studentName'];
$age = $_POST['studentAge'];
$phoneNumber = $_POST['phoneNumber'];

// Perform the insertion into the database
$sql = "INSERT INTO users (name, age, phone_number,email,password) VALUES ('$name', $age, '$phoneNumber','','')";
$result = $conn->query($sql);

// Close the database connection
$conn->close();

// Return a response (you can customize this based on your needs)
if ($result) {
    echo 'success';
} else {
   echo 'error';
}
?>