<?php
include('../functions.php');
include('functions1.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'addFinancialRecord') {
        $studentId =$_POST['data']['studentId'];
        $amountPaid = $_POST['data']['amountPaid'];
        $paymentDate = $_POST['data']['paymentDate'];

        if ($studentId > 0 && $amountPaid > 0 && !empty($paymentDate)) {
            // Add financial record to the database
            $conn = connectToDatabase();
            $sql = "INSERT INTO financial_records (student_id, amount_paid, payment_date) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ids", $studentId, $amountPaid, $paymentDate);
            
            if ($stmt->execute()) {
                // Successful insertion
                echo 'success';
            } else {
                // Error during insertion
                echo 'error';
            }

            $stmt->close();
            $conn->close();
        } else {
            echo 'Invalid input data.';
        }
    } else {
        echo 'Invalid action.';
    }
} else {
    echo 'Invalid request.';
}
?>
