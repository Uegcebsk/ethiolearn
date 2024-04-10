<?php
// Parse parameters from the URL
$urlParams = $_SERVER['REQUEST_URI'];
$paramsArray = explode('course_id=', $urlParams);
$course_id = explode('&', $paramsArray[1])[0];
$paramsArray = explode('stu_id=', $urlParams);
$stu_id = explode('&', $paramsArray[1])[0];
$paramsArray = explode('amount=', $urlParams);
$amount = $paramsArray[1];

// Now you have the extracted parameters
echo "Course ID: $course_id<br>";
echo "Student ID: $stu_id<br>";
echo "Amount: $amount<br>";
?>
