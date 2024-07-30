<?php
require_once("vendor/autoload.php");
require_once("../functions.php");

define('AT_USERNAME', 'sandbox');
define('AT_APIKEY', '021274f69e8cab8353a2f220d5bdcb0a184b1b97134deebed54371c3a8a8c26a');
define('AT_ENVIRONMENT', 'sandbox'); // or 'production' based on your Africa's Talking environment

$sessionId = $_POST['sessionId'];
$serviceCode = $_POST['serviceCode'];
$phoneNumber = $_POST['phoneNumber'];
$text = $_POST['text'];

// Check if the user is registered
$check = ussdlogin($phoneNumber);

if ($check > 0) {
    if ($text == "") {
        // Continue the conversation by asking for the password
        echo "CON Enter password:";
    } else {
        $pword=$text;
        // Complete the login process and provide a response
        $login = ussdLoginFinal($text, $phoneNumber);

        if ($login == "yes") {
            // Successful login. Provide main menu options.
            echo "CON Successful login.\n1. Student Attendance\n2. Student results ";
            // Handle menu options based on user input
            if ($text == $pword."**1") {
                // Logic for Student Attendance option
                echo "END Your Student Attendance logic goes here.";
            } elseif ($text == "2") {
                // Logic for Student Results option
                echo "END Your Student Results logic goes here.";
            }
        } else {
            // Handle unsuccessful login
            echo "END Invalid credentials. Login failed.";
        }
        
    }
} else {
    // User not registered in the system
    echo "END User not registered in the system ";
}
?>
