<?php
include_once("../DB_Files/db.php");

// Retrieve data from the request
$courseId = isset($_POST['course_id']) ? $_POST['course_id'] : '';
$progress = isset($_POST['progress']) ? $_POST['progress'] : '';

// Perform database operation to save progress
if (!empty($courseId) && !empty($progress)) {
    $studentId = ""; // Get student ID from session or any other method

    // Check if the progress already exists in the database
    $sql = "SELECT id FROM lesson_progress WHERE student_id=? AND course_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $studentId, $courseId);
    $stmt->execute();
    $stmt->store_result();
    $numRows = $stmt->num_rows;

    if ($numRows > 0) {
        // Update existing progress
        $sql = "UPDATE lesson_progress SET progress=?, timestamp=NOW() WHERE student_id=? AND course_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $progress, $studentId, $courseId);
        $stmt->execute();
    } else {
        // Insert new progress
        $sql = "INSERT INTO lesson_progress (student_id, course_id, type, progress, completed, timestamp) VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        // Assuming type and completed are default values
        $type = "video";
        $completed = 0;
        $stmt->bind_param("iisii", $studentId, $courseId, $type, $progress, $completed);
        $stmt->execute();
    }

    $stmt->close();
}
?>
