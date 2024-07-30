<?php

$action = isset($_POST['action']) ? $_POST['action'] : null;

function getStudentById($studentId) {
    // Implement this function to fetch student data by ID from the database
    $conn = connectToDatabase();
    $sql = "SELECT * FROM students WHERE id = $studentId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $studentData = $result->fetch_assoc();
        $conn->close();
        return $studentData;
    }

    $conn->close();
    return null;
}

function deleteStudent($studentId) {
    // Implement this function to delete a student by ID from the database
    $conn = connectToDatabase();
    $sql = "DELETE FROM students WHERE id = $studentId";
    $conn->query($sql);
    $conn->close();
}

function saveEditedStudent($editedData) {
    // Implement this function to save edited student data to the database
    $conn = connectToDatabase();
    $id = $editedData['id'];
    // Update other fields as needed
    $sql = "UPDATE students SET ... WHERE id = $id";
    $conn->query($sql);
    $conn->close();
}

// Add other functions as needed

if ($action == 'getStudent') {
    $studentId = $_POST['id'];
    $studentData = getStudentById($studentId);
    include('edit_student_modal.php');
    exit();
}

if ($action == 'deleteStudent') {
    $studentId = $_POST['id'];
    deleteStudent($studentId);
    exit();
}

if ($action == 'saveEditedStudent') {
    $editedData = $_POST['data'];
    saveEditedStudent($editedData);
    exit();
}
function getMonthName($monthNumber) {
    $months = [
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December',
    ];

    return isset($months[$monthNumber]) ? $months[$monthNumber] : 'Invalid Month';
}
?>
