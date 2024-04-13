<?php
session_start();
include_once("../DB_Files/db.php");

// Check if payment details are stored in the session
if(isset($_SESSION['payment_details'])) {
    // Retrieve payment details from the session
    $payment_details = $_SESSION['payment_details'];

    // Unpack payment details from the session array
    $tx_ref = $payment_details['tx_ref'];
    $amount = $payment_details['amount'];
    $course_id = $payment_details['course_id'];
    $stu_id = $payment_details['stu_id'];

    // Retrieve course and student information from the database
    $course_sql = "SELECT course_name FROM course WHERE course_id = '$course_id'";
    $course_result = $conn->query($course_sql);
    $course_row = $course_result->fetch_assoc();
    $course_name = $course_row['course_name'];

    $student_sql = "SELECT stu_name, stu_email FROM students WHERE stu_id = '$stu_id'";
    $student_result = $conn->query($student_sql);
    $student_row = $student_result->fetch_assoc();
    $student_name = $student_row['stu_name'];
    $student_email = $student_row['stu_email'];

    // Insert order details into the database
    $order_id = uniqid();
    $date = date('Y-m-d');
    $sql = "INSERT INTO courseorder(order_id, stu_id, course_id, amount, date, course_name, stu_name, stu_email, tx_ref) 
            VALUES ('$order_id', '$stu_id', '$course_id', '$amount', '$date', '$course_name', '$student_name', '$student_email', '$tx_ref')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to MyCourses page after successful insertion
        header('Location: MyCourse.php');
        exit;
    } else {
        // Handle insertion failure
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Clear the payment details from the session
    unset($_SESSION['payment_details']);
} else {
    // If payment details are not found in the session, redirect to an error page
    header('Location: error.php');
    exit;
}
?>
