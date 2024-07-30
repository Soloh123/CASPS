<?php
include('../functions.php');
include('functions1.php');

// Handle form submissions or other logic if needed
// ...

// Fetch student data with financial records
$conn = connectToDatabase();
$sql = "SELECT * FROM users";
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
        <h1>Admin</h1>
            <a class="navbar-brand" href="dashboard.php">Admin Panel</a>
            <a class="nav-link" href="index.php">Students</a>
            <a class="navbar-brand" href="results.php">Results</a>
            <a class="nav-link" href="attendance.php">Attendance</a>
            <a class="nav-link" href="account.php">Financial Accounts</a>
        </nav>

        <main role="main" class="col-md-10 ml-sm-auto">
            <div class="container mt-4">
                <h1>Student Records</h1>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addResultModal">
                    Add New Result
                </button>
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
                                        onclick="viewResultsModal(<?php echo $student['id']; ?>)">View Results
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
                <h5 class="modal-title" id="viewFinancialModalLabel">View Results</h5>
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
<div class="modal fade" id="addResultModal" tabindex="-1" role="dialog" aria-labelledby="addResultModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addResultModalLabel">Add New Result</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Your Add New Result Form Goes Here -->
                <form id="addResultForm">
                <div class="form-group">
                        <label for="unit">Student Id:</label>
                <select class="form-control" id="studentId">
                    <?php
                    $conn=connectToDatabase();
                    $sql="select * from users";
                    $query=mysqli_query($conn,$sql);
                    while($row=mysqli_fetch_assoc($query))
                    {
                        echo "<option value='".$row['id']."'>".$row['id']."</option>";
                    }
                    ?>
                    </select>
                </div>
                <div class="form-group">
                        <label for="unit">Student Name:</label>
                <select class="form-control" id="studentName">
                    <?php
                    $conn=connectToDatabase();
                    $sql="select * from users";
                    $query=mysqli_query($conn,$sql);
                    while($row=mysqli_fetch_assoc($query))
                    {
                        echo "<option value='".$row['name']."'>".$row['name']."</option>";
                    }
                    ?>
                    </select>
                </div>
                    <div class="form-group">
                    <label for="attendanceStudent">Unit:</label>
                        <select class="form-control" id="unit" name="unit">
                        <option value="Project2">Project2</option>  
                        <option value="Professional ethics">Professional ethics</option>  
                        <option value="Company accounting">Company accounting</option>  
                        <option value="Object oriented analysis and design ">Object oriented analysis and design </option>                      
                        <option value="Project management">Project management</option>                      
                    </select>
                        </div>
                    <div class="form-group">
                        <label for="semester">Semester:</label>
                        <input type="text" class="form-control" id="semester" name="semester" required>
                    </div>
                    <div class="form-group">
                        <label for="grade">Marks:</label>
                        <input type="text" class="form-control" id="marks" name="marks" required>
                    </div>
                    <div class="form-group">
                        <label for="grade">Grade:</label>
                        <input type="text" class="form-control" id="grade" name="grade" required>
                    </div>
                    <!-- Add more form fields as needed -->
                    <button type="button" class="btn btn-primary" onclick="addNewResult()">Add Result</button>
                </form>
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
    function addNewResult(){
        // Collect data from the form
        var resultData = {
            unit: $('#unit').val(),
            semester: $('#semester').val(),
            grade: $('#grade').val(),
            studentId:$('#studentId').val(),
            studentName:$('#studentName').val(),
            marks:$('#marks').val()
        };

        // Handle the data via AJAX
        $.ajax({
            type: 'POST',
            url: '../functions.php', // Adjust the URL based on your file structure
            data: { action: 'addNewResult', data: resultData },
            success: function (response) {
                // Handle the response from the server
                if (response === 'success') {
                    // If successful, you might want to provide feedback to the user or perform other actions
                    alert('Result added successfully');
                    // Reload the page or update the table with the new result
                    location.reload();
                } else {
                    // If an error occurred, you might want to display an error message or log the error
                    alert('Error adding result: ' + response);
                }
            }
        });
    }
    function viewResultsModal(studentId) {
        $.ajax({
            type: 'POST',
            url: 'get_results.php',
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
