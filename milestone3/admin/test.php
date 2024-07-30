<?php
include('../functions.php');
include('functions1.php');
$phoneNumber="+254702502952";
$result=getStudentAttendanceForParent($phoneNumber);
echo $result;
?>