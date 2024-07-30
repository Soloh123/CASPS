<?php
include('../functions.php');
include('functions1.php');
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
            <a class="navbar-brand" href="index.php">Admin Panel</a>
            <a class="nav-link" href="index.php">Students</a>
            <a class="navbar-brand" href="results.php">Results</a>
            <a class="nav-link" href="attendance.php">Attendance</a>
            <a class="nav-link" href="accounts.php">Financial Accounts</a>
        </nav>

        <main role="main" class="col-md-10 ml-sm-auto">
            <div class="container mt-4">
                <h1>Students</h1>

                <!-- Add New Student Button (Opens Modal) -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addStudentModal">
                    Add New Student
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
                    <?php
                    // Include functions.php and authenticateUser() here
                    authenticateUser();

                    $conn = connectToDatabase();
                    $sql = "SELECT * FROM users";
                    $result = $conn->query($sql);
                    $students = $result->fetch_all(MYSQLI_ASSOC);
                    $conn->close();

                    foreach ($students as $student):
                        ?>
                        <tr>
                            <td><?php echo $student['id']; ?></td>
                            <td><?php echo $student['name']; ?></td>
                            <td><?php echo $student['age']; ?></td>
                            <td><?php echo $student['phone_number']; ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm"
                                        onclick="editStudentModal(<?php echo $student['id']; ?>)">Edit
                                </button>
                                <button class="btn btn-danger btn-sm"
                                        onclick="deleteStudent(<?php echo $student['id']; ?>)">Delete
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

<!-- Add New Student Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog" aria-labelledby="addStudentModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStudentModalLabel">Add New Student</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Your Add New Student Form Goes Here -->
                <form id="addStudentForm">
                    <div class="form-group">
                        <label for="studentName">Name:</label>
                        <input type="text" class="form-control" id="studentName" name="studentName" required>
                    </div>
                    <div class="form-group">
                        <label for="studentAge">Age:</label>
                        <input type="number" class="form-control" id="studentAge" name="studentAge" required>
                    </div>
                    <div class="form-group">
                        <label for="phoneNumber">Phone Number:</label>
                        <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" required>
                    </div>
                    <div class="form-group">
                        <label for="phoneNumber">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <!-- Add more form fields as needed -->
                    <button type="button" class="btn btn-primary" onclick="addNewStudent()">Add Student</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Student Modal -->
<!-- Edit Student Modal -->
<div class="modal fade" id="editStudentModal" tabindex="-1" role="dialog" aria-labelledby="editStudentModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStudentModalLabel">Edit Student</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editStudentForm">
                    <input type="hidden" id="editStudentId" name="editStudentId">
                    <div class="form-group">
                        <label for="editStudentName">Name:</label>
                        <input type="text" class="form-control" id="editStudentName" name="editStudentName" required>
                    </div>
                    <div class="form-group">
                        <label for="editStudentAge">Age:</label>
                        <input type="number" class="form-control" id="editStudentAge" name="editStudentAge" required>
                    </div>
                    <div class="form-group">
                        <label for="editPhoneNumber">Phone Number:</label>
                        <input type="tel" class="form-control" id="editPhoneNumber" name="editPhoneNumber" required readonly>
                    </div>
                    <!-- Add more form fields as needed -->
                    <button type="button" class="btn btn-primary" onclick="saveEditedStudent()">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
    function editStudentModal(studentId) {

    $.ajax({
        type: 'POST',
        url: 'getStudent.php',
        data: { id: studentId },
        dataType: 'json', // Specify JSON data type
        success: function (response) {
            // Populate the modal fields with the received data
            $('#editStudentId').val(response.id);
            $('#editStudentName').val(response.name);
            $('#editStudentAge').val(response.age);
            $('#editPhoneNumber').val(response.phone_number);
            $('#editStudentModal').modal('show');
        }
    });
}


    function deleteStudent(studentId) {
        // Confirm deletion and handle via AJAX
        if (confirm('Are you sure you want to delete this student?')) {
            $.ajax({
                type: 'POST',
                url: '../functions.php',
                data: {action: 'deleteStudent', id: studentId},
                success: function () {
                    // Reload the page or update the table without the deleted student
                    location.reload();
                }
            });
        }
    }

    function saveEditedStudent() {
    // Collect edited data and handle via AJAX
    var editedData = {
        name: $('#editStudentName').val(),
        age: $('#editStudentAge').val(),
        phoneNumber: $('#editPhoneNumber').val()
        // Add other fields as needed
    };

    $.ajax({
        type: 'POST',
        url: '../functions.php',
        data: { action: 'saveEditedStudent', data: editedData },
        success: function (response) {
            // Handle the response from the server
            if (response === 'success') {
                // If successful, close the modal and provide feedback to the user
                $('#editStudentModal').modal('hide');
                alert('Student edited successfully');
                // Reload the page or update the table with the edited student data
                location.reload();
            } else {
                // If an error occurred, you might want to display an error message or log the error
                alert('Error editing student: ' + response);
            }
        }
    });
}

    // Function to add a new student
    function addNewStudent() {
        // Collect data from the form
        var studentData = {
            name: $('#studentName').val(),
            age: $('#studentAge').val(),
            phoneNumber: $('#phoneNumber').val()
            // Add other fields as needed
        };

        // Handle the data via AJAX
        $.ajax({
            type: 'POST',
            url: '../functions.php', // Adjust the URL based on your file structure
            data: { action: 'addNewStudent', data: studentData },
            success: function (response) {
                // Handle the response from the server
                if (response === 'success') {
                    // If successful, you might want to provide feedback to the user or perform other actions
                    alert('Student added successfully');
                    // Reload the page or update the table with the new student
                    location.reload();
                } else {
                    // If an error occurred, you might want to display an error message or log the error
                    alert('Error adding student'+response);
                    alert(response);
                }
            }
        });
    }
</script>

</body>
</html>
