<?php
// addAttendance.php

include('../functions.php');
include('functions1.php');

if (isset($_POST['action']) && $_POST['action'] === 'addMonthlyAttendance' && isset($_POST['data'])) {
    $attendanceData = $_POST['data'];
    // Sanitize and validate data (implement these functions as needed)
    $studentId = $attendanceData['studentId'];
    $month = $attendanceData['month'];
    $attendancePercentage = $attendanceData['attendancePercentage'];
    $unit=$attendanceData['unit'];
    // Validate that the percentage is within a reasonable range (e.g., 0 to 100)
    if (!is_numeric($attendancePercentage) || $attendancePercentage < 0 || $attendancePercentage > 100) {
        echo 'error';
        exit;
    }

    // Perform the database insertion
    $conn = connectToDatabase();

    // Assuming there is a table named 'attendance' with columns like 'student_id', 'month', 'percentage', etc.
    $sql = "INSERT INTO Attendance (student_id, Month, Attendance,unit) VALUES ('$studentId', '$month', '$attendancePercentage','$unit')";

    if ($conn->query($sql) === TRUE) {
        $recipient = getStudentPhoneNumber($studentId); // Replace with the recipient's phone number
        $message = 'Monthly attendance Updated.Check it out in our system';
      sendMessage($recipient, $message);
        echo 'success';
    } else {
        echo 'error';
    }

    $conn->close();
} else {
    echo 'Invalid request';
}
?>
