<?php
require_once("functions.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $userType = $_POST['userType'];
    $phoneNumber = $_POST['phoneNumber'];
    $password = $_POST['password'];

    // Perform login verification based on user type
    if ($userType == 'Admin') {
        $result = ussdLoginFinal($password, $phoneNumber);
        if($result=="yes")
        {
            $_SESSION['user_id']=$phoneNumber;
               // Redirect to a dashboard or home page
        header("Location: admin");
        exit();
        }
        else {
            // Show an error message or redirect to login page with error flag
            header("Location: index.php?error=1");
            exit();
        }
    } elseif ($userType == 'Parent') {
        // You might need additional logic for parent login
        // For example, fetching parent ID based on phone number and then verifying credentials
        $result1 = ussdLoginFinal($password, $phoneNumber);
        if($result1=='yes')
        {
        $_SESSION['user_id']=$phoneNumber;
        header("Location: parent");
        exit();
        }
        else {
            // Show an error message or redirect to login page with error flag
            header("Location: index.php?error=1");
            exit();
        }
    }
}
?>
