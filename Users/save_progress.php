<?php
include_once("../DB_Files/db.php");

// Check if all required parameters are set
if (isset($_POST['lesson_id'], $_POST['student_id'], $_POST['course_id'], $_POST['type'], $_POST['progress'], $_POST['completed'])) {
    $lessonId = $_POST['lesson_id'];
    $studentId = $_POST['student_id'];
    $courseId = $_POST['course_id'];
    $type = $_POST['type'];
    $progress = $_POST['progress'];
    $completed = $_POST['completed'];
    $timestamp = date('Y-m-d H:i:s');

    // Insert progress data into the database
    $sql = "INSERT INTO lesson_progress (student_id, lesson_id, course_id, type, progress, completed, timestamp) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiisiii", $studentId, $lessonId, $courseId, $type, $progress, $completed, $timestamp);
    if ($stmt->execute()) {
        echo "Progress saved successfully.";
    } else {
        echo "Error: " . $conn->error;
    }
    $stmt->close();
} else {
    echo "Error: Incomplete parameters.";
}
?>
