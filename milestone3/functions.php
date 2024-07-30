<?php
 session_start();
 use AfricasTalking\SDK\AfricasTalking;
 require 'ussd/vendor/autoload.php';
// Include this file in other PHP files where you need these functions
//require_once("vendor/autoload.php");
// Function for Database Connection
function connectToDatabase() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "students";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
if(isset($_POST['action']))
{
    if($_POST['action']=='deleteStudent')
    {
        $id=$_POST['id'];
       $conn=connectToDatabase();
       $sql="delete from users where id='$id'";
       $query=mysqli_query($conn,$sql);
       if($query)
       {
        echo "success";
       }
       else{
        echo "Update failed".mysqli_error($conn);
       }
    }
    if($_POST['action']=='deleteResult')
    {
        $id=$_POST['id'];
       $conn=connectToDatabase();
       $sql="delete from results where id='$id'";
       $query=mysqli_query($conn,$sql);
       if($query)
       {
        echo "success";
       }
       else{
        echo "Update failed".mysqli_error($conn);
       }
    }
    if($_POST['action']=='addNewResult')
    {
        $unit=$_POST['data']['unit'];
        $semester=$_POST['data']['semester'];
        $grade=$_POST['data']['grade'];
        $studentId=$_POST['data']['studentId'];
        $studentName=$_POST['data']['studentName'];
        $marks=$_POST['data']['marks'];
        $response=addStudentResults($studentId,$studentName,$semester,$unit,$marks,$grade);
        echo $response;
    }
    if($_POST['action']=='addNewStudent')
    {
    $response=addNewStudent($_POST['data']);
    echo $response;
    }
    if($_POST['action']=="saveEditedResult")
    {
        $id=$_POST['data']['id'];;
        $unit=$_POST['data']['unit'];;
        $semester=$_POST['data']['semester'];
        $grade=$_POST['data']['grade'];
       $conn=connectToDatabase();
       $sql="update results set unit='$unit',semester='$semester',grade='$grade' where id='$id'";
       $query=mysqli_query($conn,$sql);
       if($query)
       {
        echo "success";
       }
       else{
        echo "Update failed".mysqli_error($conn);
       }
    }
    else if($_POST['action']=="saveEditedStudent")
    {
        $name=$_POST['data']['name'];;
        $age=$_POST['data']['age'];;
        $phone_number=$_POST['data']['phoneNumber'];
       $conn=connectToDatabase();
       $sql="update users set name='$name',age='$age',phone_number='$phone_number' where phone_number='$phone_number'";
       $query=mysqli_query($conn,$sql);
       if($query)
       {
        echo "success";
       }
       else{
        echo "Update failed".mysqli_error($conn);
       }
    }
}
function ussdLogin($phoneNumber) {
    // Validate the provided password against the stored password for the phone number
    $conn = connectToDatabase();

    // Perform a query to check the credentials (modify the query based on your database schema)
    $query = "SELECT * FROM users WHERE phone_number = '$phoneNumber'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Valid credentials
        $conn->close();
        return 1; // You can customize this response based on your requirements
    } else {
        // Invalid credentials
        $conn->close();
        return 0; // You can customize this response based on your requirements
    }
}
function ussdLoginFinal($password, $phoneNumber) {
    // Validate the provided password against the stored password for the phone number
    $conn = connectToDatabase();

    // Perform a query to check the credentials (modify the query based on your database schema)
    $query = "SELECT * FROM users WHERE phone_number = '$phoneNumber' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Valid credentials
        $conn->close();
        return "yes"; // You can customize this response based on your requirements
    } else {
        // Invalid credentials
        $conn->close();
        return "no"; // You can customize this response based on your requirements
    }
}

// Function for User Authentication
function authenticateUser() {

    // Check if user is logged in, redirect if not
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../index.php");
        exit();
    }

    // Add more authentication logic based on user roles (parent, admin, etc.)
}

// Function to Fetch Student Data for Parent
function getStudentDataForParent($phoneNumber) {
    $conn = connectToDatabase();

    // Implement logic to fetch student data based on the parent's user ID
     $sql = "SELECT * FROM users WHERE phone_number=".$phoneNumber;

    $result = $conn->query($sql);
    $row=mysqli_fetch_assoc($result);
    // Add code to process and return the fetched data
    // Close the database connection
    $conn->close();

    // Return the fetched data
    return $row;
}

// Function to Update Student Results
function addStudentResults($studentId,$studentName,$semester,$unit,$marks,$grade) {
    $conn = connectToDatabase();

    // Implement logic to update student results based on the student ID
    $sql = "insert into results(student_id,student_name,unit,semester,Marks,grade) values('$studentId','$studentName','$unit','$semester','$marks','$grade')";

    $result=$conn->query($sql);
    $recipient=getStudentPhoneNumber($studentId);
    $message="Dear Parent The results of your child has been updated checkout in the system.";
    sendMessage($recipient, $message);
        echo "success";
    
    // Close the database connection
    $conn->close();
}

// Function to Record Monthly Attendance
function recordMonthlyAttendance($studentId, $month, $attendance,$unitcode) {
    $conn = connectToDatabase();

    // Implement logic to record monthly attendance based on the student ID and month
     $sql = "INSERT INTO attendance (student_id, month, attendance_column) VALUES ($studentId, '$month', '$attendance')";

    $conn->query($sql);
    $recipient = getStudentPhoneNumber($studentId); // Replace with the recipient's phone number
    $message = 'Monthly attendance Updated.Check it out in our system';
  sendMessage($recipient, $message);
    // Close the database connection
    $conn->close();
}
function getStudentPhoneNumber($student_id)
{
    $conn = connectToDatabase();

    $sql = "SELECT phone_number FROM users WHERE id = '$student_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the first row since it's expected to have only one result
        $row = $result->fetch_assoc();
        $phoneNumber = $row['phone_number'];

        // Close the database connection
        $conn->close();

        return $phoneNumber;
    } else {
        // Close the database connection
        $conn->close();

        // Return a default or handle the case where no phone number is found
        return null;
    }
}
// Function to add a new student
function getStudentFeesForParent($phoneNumber) {
    $conn = connectToDatabase();

    $sql = "SELECT users.*, financial_records.amount_paid, financial_records.payment_date
    FROM users
    LEFT JOIN financial_records ON users.id = financial_records.student_id where users.phone_number='$phoneNumber'";
$result1 = $conn->query($sql);
$students = $result1->fetch_all(MYSQLI_ASSOC);
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $resultsData = "";
        while ($row = $result->fetch_assoc()) {
            $resultsData .= "Amount: " . $row['amount_paid'] . ", Payment Date: " . $row['payment_date']."\n";
        }
        $conn->close();
        return $resultsData;
    } else {
        $conn->close();
        return false;
    }
}
function getStudentResultsForParent($phoneNumber) {
    $conn = connectToDatabase();

    $sql = "SELECT users.name, results.unit, results.semester, results.grade
            FROM users
            LEFT JOIN results ON users.id = results.student_id
            WHERE users.phone_number = '$phoneNumber'";

    $result = mysqli_query($conn,$sql);
echo mysqli_error($conn);
        $resultsData = "";
        while ($row = mysqli_fetch_assoc($result)) {
            $resultsData .="Unit: " . $row['unit'] . ", Semester: " . $row['semester'] . ", Grade: " . $row['grade'] . "\n";
        }
        $conn->close();
        return $resultsData;
}
function getStudentAttendanceForParent($phoneNumber) {
    $conn = connectToDatabase();

    $sql = "SELECT users.name, Attendance.unit, Attendance.Attendance, Attendance.Month
            FROM users
            LEFT JOIN Attendance ON users.id = Attendance.student_id
            WHERE users.phone_number = '$phoneNumber'";

    $result = mysqli_query($conn,$sql);
echo mysqli_error($conn);
        $resultsData = "";
        while ($row = mysqli_fetch_assoc($result)) {
            $resultsData .="<br>Unit: " . $row['unit'] . ", Attendance: " . $row['Attendance'] . "%, Month: " . $row['Month'] . "";
        }
        $conn->close();
        return $resultsData;
}
function addNewStudent($data) {
    $conn = connectToDatabase();

    // Extract data from the $data array
    $name = $data['name'];
    $age = $data['age'];
    $phoneNumber = $data['phoneNumber'];

    // Perform the insertion into the database
    $sql = "INSERT INTO users(name, age, phone_number,email,password) VALUES ('$name', $age, '$phoneNumber','','123456')";
    $result = $conn->query($sql);

    // Close the database connection
    $conn->close();

    // Return a response (you can customize this based on your needs)
    if ($result) {
        return 'success';
    } else {
        return 'error';
    }
}
// Function to Send Notifications
function sendMessage($recipient, $message) {
    $text=$message;
    $phone=$recipient;
    $username = 'kokoAp'; // use 'sandbox' for development in the test environment
    $apiKey   = '66cf7b31c9483373a9b23f2040f32f48d048f9a093ca3c5212670ead01851d27'; // use your sandbox app API key for development in the test environment
    $AT = new AfricasTalking($username,$apiKey);
    
    // Get one of the services
    $sms      = $AT->sms();
    
    // Use the service
    $result   = $sms->send([
        'to'      => $phone,
        'message' => $text
    ]);
}
?>
