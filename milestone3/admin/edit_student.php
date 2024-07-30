<div class="modal fade" id="editStudentModal" tabindex="-1" role="dialog" aria-labelledby="addStudentModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStudentModalLabel">Add New Student</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Your Add New Student Form Goes Here -->
                <form id="editStudentForm">
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