<?php
include('../functions.php');
include('functions1.php');

$phone=$_SESSION['user_id'];

// Fetch student data with financial records
$conn = connectToDatabase();
$sql = "SELECT *
        FROM users where phone_number='$phone'";
$result = $conn->query($sql);
$students = $result->fetch_all(MYSQLI_ASSOC);
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <style>
        /* Custom styles go here */
        .container-fluid {
            margin-top: 20px;
        }

        .sidenav {
            height: 100%;
            width: 250px;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #d1d5d8;
            padding-top: 20px;
        }

        .sidenav a {
            padding: 8px 8px 8px 16px;
            text-decoration: none;
            font-size: 18px;
            color: #007bff;
            display: block;
        }

        .sidenav a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
    <nav class="col-md-2 d-none d-md-block bg-dark sidenav">
        <h1>Parent Page</h1>
        <a class="navbar-brand" href="results.php">Results</a>
            <a class="nav-link" href="attendance.php">Attendance</a>
            <a class="nav-link" href="accounts.php">Financial Accounts</a>
        </nav>

        <main role="main" class="col-md-10 ml-sm-auto">
            <div class="container mt-4">
                <h1>Student Records</h1>

                <!-- Table -->
                <table class="table table-bordered table-striped mt-3">
                    <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Phone Number</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?php echo $student['id']; ?></td>
                            <td><?php echo $student['name']; ?></td>
                            <td><?php echo $student['age']; ?></td>
                            <td><?php echo $student['phone_number']; ?></td>
                            <td>
                                <button class="btn btn-success btn-sm"
                                        onclick="viewFinancialModal(<?php echo $student['id']; ?>)">View Financial
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </main>
    </div>
</div>

<!-- View Attendance Modal -->
<div class="modal fade" id="viewAttendanceModal" tabindex="-1" role="dialog" aria-labelledby="viewAttendanceModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewAttendanceModalLabel">View Monthly Attendance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Your View Monthly Attendance Content Goes Here -->
                <!-- Display attendance details for the selected student -->
                <div id="attendanceDetails"></div>
            </div>
        </div>
    </div>
</div>

<!-- View Financial Details Modal -->
<div class="modal fade" id="viewFinancialModal" tabindex="-1" role="dialog" aria-labelledby="viewFinancialModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewFinancialModalLabel">View Financial Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Your View Financial Details Content Goes Here -->
                <!-- Display financial details for the selected student -->
                <div id="financialDetails"></div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
    function viewAttendanceModal(studentId) {
        $.ajax({
            type: 'POST',
            url: 'getAttendance.php',
            data: { id: studentId },
            dataType: 'html', // Use 'html' if you're returning HTML content
            success: function (response) {
                // Display attendance details in the modal
                $('#attendanceDetails').html(response);
                $('#viewAttendanceModal').modal('show');
            }
        });
    }

    function viewFinancialModal(studentId) {
        $.ajax({
            type: 'POST',
            url: 'getFinancialDetails.php',
            data: { id: studentId },
            dataType: 'html',
            success: function (response) {
                // Display financial details in the financial modal
                $('#financialDetails').html(response);
                $('#viewFinancialModal').modal('show');
            }
        });
    }
</script>

</body>
</html>
