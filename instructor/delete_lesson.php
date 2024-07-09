<?php
include_once("../DB_Files/db.php");
include_once("header copy.php");

// Retrieve instructor's ID from session
$l_id = $_SESSION['l_id'];

// Check if a lesson ID is provided for deletion
if (isset($_GET['lesson_id'])) {
    $lesson_id = (int)$_GET['lesson_id'];

    // Prepare the SQL delete statement
    $sql_delete_lesson = "DELETE FROM lesson WHERE lesson_id = ? AND course_id IN (SELECT course_id FROM course WHERE lec_id = ?)";
    $stmt_delete_lesson = $conn->prepare($sql_delete_lesson);
    $stmt_delete_lesson->bind_param("ii", $lesson_id, $l_id);

    // Execute the delete statement
    if ($stmt_delete_lesson->execute()) {
        // Redirect to lesson management page with success message
        echo "<script>setTimeout(()=>{window.location.href='Lesson.php';},300);</script>";
    } else {
        // Redirect to lesson management page with error message
        header("Location: lessonManagement.php?msg=Failed to delete lesson");
    }

    // Close the statement
    $stmt_delete_lesson->close();
} else {
    // Redirect to lesson management page if no lesson ID is provided
    header("Location: lessonManagement.php");
}

// Close the database connection
$conn->close();
?>
