<?php
include("../functions.php");
$conn=connectToDatabase();
$id=$_POST['id'];
$sql="select * from users where id='$id'";
$query=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($query);
header('Content-Type: application/json');
echo json_encode($row);
?>