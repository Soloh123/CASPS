<?php
include('../functions.php');
include('functions1.php');
if (isset($_POST['id'])) {
    $resultId = $_POST['id'];
    $conn=connectToDatabase();
    $sql="select * from results where id='$resultId'";
    $query=mysqli_query($conn,$sql);
    $result=mysqli_fetch_assoc($query);

    // Send the result data as JSON
    header('Content-Type: application/json');
    echo json_encode($result);
    exit;
}
?>
