<?php
// Initialize the session
include_once("../DB_Files/db.php");
include_once("../Inc/Header.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $q_body = $_POST['q_body'];
    $stu_id = $_SESSION['stu_id'];
    $course = $_POST['courses'];

    if (!empty($q_body) && $q_body != 'Enter Question Body') {
        // Prepare an insert statement
        $sql = "INSERT INTO questions (q_stu_id, course_id, q_body, resolved) VALUES (?,?,?, ?)";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            $resolved = 'no';
            mysqli_stmt_bind_param($stmt, "ssss", $stu_id, $course, $q_body, $resolved);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to forum.php after showing the success message
                echo '<script>alert("Question successfully posted to forum"); window.location.href = "forum.php";</script>';
                exit; // Ensure no further code execution after redirection
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    } else {
        echo "Please fill up question title and body.";
    }
}
?>
