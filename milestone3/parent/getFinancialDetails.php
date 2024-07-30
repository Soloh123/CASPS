<?php
include('../functions.php');
include('functions1.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) && is_numeric($_POST['id'])) {
        $studentId = $_POST['id'];

        // Fetch financial details for the specified student
        $conn = connectToDatabase();
        $sql = "SELECT * FROM financial_records WHERE student_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $studentId);
        $stmt->execute();
        $result = $stmt->get_result();
        $financialRecords = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        $conn->close();

        // Display financial details
        if (!empty($financialRecords)) {
            echo '<h5>Financial Records</h5>';
            echo '<table class="table table-bordered">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>ID</th>';
            echo '<th>Amount Paid</th>';
            echo '<th>Payment Date</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            $total=0;
            foreach ($financialRecords as $record) {
                $total=$total+$record['amount_paid'];
                echo '<tr>';
                echo '<td>' . $record['id'] . '</td>';
                echo '<td>' . $record['amount_paid'] . '</td>';
                echo '<td>' . $record['payment_date'] . '</td>';
                echo '</tr>';
            }
            echo "Total paid:".$total;
            $remaining=29000-$total;
            echo "<br>Remaining:".$remaining;
            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p>No financial records found for this student.</p>';
        }
    } else {
        echo 'Invalid student ID.';
    }
} else {
    echo 'Invalid request.';
}
?>
