<?php

include('../functions.php');
include('functions1.php');

if (isset($_POST['id'])) {
    $studentId = $_POST['id'];
    $conn = connectToDatabase();
$sql = "SELECT * FROM Attendance WHERE student_id = $studentId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    echo '<table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Month</th>
                        <th>Percentage</th>
                    </tr>
                </thead>
                <tbody>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                    <td>' . $row['student_id'] . '</td>
                    <td>' . getMonthName($row['Month']) . '</td>
                    <td>' . $row['Attendance'] . '</td>
                  </tr>';
        }

        echo '</tbody></table>';
    } else {
        echo 'No attendance records found for the selected student.';
    }

    $conn->close();
} else {
    echo 'Invalid request';
}
?>
