<?php
// Include this file in other PHP files where you need these functions
require_once("vendor/autoload.php");
// Function for Database Connection
function connectToDatabase() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "students";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
function ussdLogin($phoneNumber) {
    // Validate the provided password against the stored password for the phone number
    $conn = connectToDatabase();

    // Perform a query to check the credentials (modify the query based on your database schema)
    $query = "SELECT * FROM users WHERE phone_number = '$phoneNumber'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Valid credentials
        $conn->close();
        return 1; // You can customize this response based on your requirements
    } else {
        // Invalid credentials
        $conn->close();
        return 0; // You can customize this response based on your requirements
    }
}
function ussdLoginFinal($password, $phoneNumber) {
    // Validate the provided password against the stored password for the phone number
    $conn = connectToDatabase();

    // Perform a query to check the credentials (modify the query based on your database schema)
    $query = "SELECT * FROM users WHERE phone_number = '$phoneNumber' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Valid credentials
        $conn->close();
        return "yes"; // You can customize this response based on your requirements
    } else {
        // Invalid credentials
        $conn->close();
        return "no"; // You can customize this response based on your requirements
    }
}

// Function for User Authentication
function authenticateUser() {
    session_start();

    // Check if user is logged in, redirect if not
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    // Add more authentication logic based on user roles (parent, admin, etc.)
}

// Function to Fetch Student Data for Parent
function getStudentDataForParent($parentUserId) {
    $conn = connectToDatabase();

    // Implement logic to fetch student data based on the parent's user ID
     $sql = "SELECT * FROM students WHERE parent_id = $parentUserId";

    $result = $conn->query($sql);

    // Add code to process and return the fetched data

    // Close the database connection
    $conn->close();

    // Return the fetched data
    return $result;
}

// Function to Update Student Results
function updateStudentResults($studentId, $newResults) {
    $conn = connectToDatabase();

    // Implement logic to update student results based on the student ID
    $sql = "UPDATE results SET result_column = '$newResults' WHERE student_id = $studentId";

    $conn->query($sql);

    // Close the database connection
    $conn->close();
}

// Function to Record Monthly Attendance
function recordMonthlyAttendance($studentId, $month, $attendance) {
    $conn = connectToDatabase();

    // Implement logic to record monthly attendance based on the student ID and month
     $sql = "INSERT INTO attendance (student_id, month, attendance_column) VALUES ($studentId, '$month', '$attendance')";

    $conn->query($sql);
    $recipient = '+254712345678'; // Replace with the recipient's phone number
    $message = 'Hello, this is a test message from your application.';
    
    if (sendMessage($recipient, $message)) {
        echo 'Message sent successfully.';
    } else {
        echo 'Failed to send message.';
    }
    // Close the database connection
    $conn->close();
}

// Function to Send Notifications
function sendMessage($recipient, $message) {
    // Create a new instance of the SMS class
    $sms = Africastalking::sms();

    // Set the phone numbers you want to send to
    $recipients = [$recipient];

    // Set the message to be sent
    $smsMessage = ['to' => $recipients, 'message' => $message];

    try {
        // Send the message
        $response = $sms->send($smsMessage);

        // Process the response as needed
        // $response['status'], $response['smsMessageData']

        // You can log or handle the response accordingly
        // For example, you might check if the message was sent successfully
        if ($response['status'] === 'success') {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        // Handle any errors that occurred during the process
        // Log or display the error message
        return false;
    }
}
?>
