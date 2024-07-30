<?php
include('../functions.php');
include('functions1.php');
if (isset($_POST['id'])) {
    $resultId = $_POST['id'];
    $conn=connectToDatabase();
    $sql="select * from results where student_id='$resultId'";
    $query=mysqli_query($conn,$sql);
    $result=$query->fetch_all(MYSQLI_ASSOC);
    if (!empty($result)) {
        echo '<h5>Results</h5>';
        echo '<table class="table table-bordered">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Unit</th>';
        echo '<th>Semester</th>';
        echo '<th>Grade</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        foreach ($result as $record) {
            echo '<tr>';
            echo '<td>' . $record['id'] . '</td>';
            echo '<td>' . $record['unit'] . '</td>';
            echo '<td>' . $record['semester'] . '</td>';
            echo '<td>' . $record['grade'] . '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>No financial records found for this student.</p>';
    }
    exit;
}
?>
