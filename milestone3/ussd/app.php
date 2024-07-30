<?php
require_once("vendor/autoload.php");
require_once("../functions.php");

define('AT_USERNAME', 'sandbox');
define('AT_APIKEY', '021274f69e8cab8353a2f220d5bdcb0a184b1b97134deebed54371c3a8a8c26a');
define('AT_ENVIRONMENT', 'sandbox');

$sessionId = $_POST['sessionId'];
$serviceCode = $_POST['serviceCode'];
$phoneNumber = $_POST['phoneNumber'];
$text = trim($_POST['text']);

// Check if the user is already logged in
$check = ussdLogin($phoneNumber);

if ($check > 0) {
    $userInput = explode('*', $text);
    $inputStage = count($userInput);

    switch ($inputStage) {
        case 1:
            echo "CON Enter password:";
            break;

        case 2:
            $password = $userInput[1];
            $login = ussdLoginFinal($password, $phoneNumber);

            if ($login == "yes") {
                echo "CON Successful login.\n1. Student Attendance\n2. Student Results\n3. Student Fees Statement";
            } else {
                echo "END Invalid credentials. Login failed.";
            }
            break;

        case 3:
            $selectedOption = $userInput[2];

            switch ($selectedOption) {
                case 1:
                    $studentData = getStudentDataForParent($phoneNumber);
                    if ($studentData) {
                        echo "END Student Attendance:\n" .getStudentAttendanceForParent($phoneNumber);
                    } else {
                        echo "END No student data found.";
                    }
                    break;

                case 2:
                    $resultsData = getStudentResultsForParent($phoneNumber);
                    if ($resultsData) {
                        echo "END Student Results:\n$resultsData";
                    } else {
                        echo "END No results data found.";
                    }
                    break;

                case 3:
                    $feesData = getStudentFeesForParent($phoneNumber);
                    echo "END Student Fees Statement:\n$feesData";
                    break;

                default:
                    echo "END Invalid option selected.";
                    break;
            }
            break;

        default:
            echo "END Invalid input.";
            break;
    }
} else {
    echo "END User not registered in the system";
}
?>
