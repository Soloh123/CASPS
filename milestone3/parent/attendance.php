<?php
include('../functions.php');
include('functions1.php');
// Handle form submissions or other logic if needed
// ...
$phone=$_SESSION['user_id'];
// Fetch student data
$conn = connectToDatabase();
$sql = "SELECT * FROM users where phone_number='$phone'";
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
        <a class="navbar-brand" href="index.php">Dashboard</a>
            <a class="navbar-brand" href="results.php">Results</a>
            <a class="nav-link" href="attendance.php">Attendance</a>
            <a class="nav-link" href="accounts.php">Financial Accounts</a>
        </nav>

        <main role="main" class="col-md-10 ml-sm-auto">
            <div class="container mt-4">
                <h1>Monthly Attendance</h1>

                <!-- Table -->
                <table class="table table-bordered table-striped mt-3">
                    <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Phone Number</th>
                        <th>Monthly Attendance</th>
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
                                <button class="btn btn-info btn-sm"
                                        onclick="viewAttendanceModal(<?php echo $student['id']; ?>)">View
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

<!-- Add Monthly Attendance Modal -->
<div class="modal fade" id="addAttendanceModal" tabindex="-1" role="dialog" aria-labelledby="addAttendanceModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAttendanceModalLabel">Add Monthly Attendance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addAttendanceForm">
                    <div class="form-group">
                        <label for="attendanceMonth">Month:</label>
                        <select class="form-control" id="attendanceMonth" name="attendanceMonth" required>
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </div>
                    <div class="form-group">
                    <label for="attendanceStudent">Student:</label>
                        <select class="form-control" id="studentId">
                        <?php foreach ($students as $student): ?>
                            <option value=<?php echo $student['id']; ?>><?php echo $student['name']; ?></option>                        
                    <?php endforeach; ?>
                    </select>
                        </div>
                        <div class="form-group">
                        <label for="attendancePercentage">Attendance(%):</label>
                        <input type="number" class="form-control" id="attendance">
                    </div>
                 
                    <button type="button" class="btn btn-primary" onclick="addMonthlyAttendance()">Add Attendance</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- View Monthly Attendance Modal -->
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

    function addMonthlyAttendance() {
        // Collect data from the form
        var attendanceData = {
            studentId: $('#studentId').val(),
            month: $('#attendanceMonth').val(),
            attendancePercentage:$('#attendance').val(),
        };

        // Handle the data via AJAX
        $.ajax({
            type: 'POST',
            url: 'addAttendance.php', 
            data: { action: 'addMonthlyAttendance', data: attendanceData },
            success: function (response) {
                // Handle the response from the server
                if (response === 'success') {
                    // If successful, you might want to provide feedback to the user or perform other actions
                    alert('Attendance added successfully');
                    // Reload the page or update the table with the new attendance
                    location.reload();
                } else {
                    // If an error occurred, you might want to display an error message or log the error
                    alert('Error adding attendance'+response);
                }
            }
        });
    }
</script>

</body>
</html>
