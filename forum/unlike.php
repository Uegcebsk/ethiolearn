<?php
session_start();
include_once("../DB_Files/db.php");

// Get the student ID from the session
$student_id = $_SESSION['stu_id'];

// Get the answer ID from the AJAX request
$A_id = $_POST['A_id'];

// Check if the student has already liked this answer
$sql_check_like = "SELECT * FROM AnswerLikes WHERE Student_id = ? AND Answer_id = ?";
$stmt_check_like = $conn->prepare($sql_check_like);
$stmt_check_like->bind_param("ii", $student_id, $A_id);
$stmt_check_like->execute();
$stmt_check_like->store_result();

if ($stmt_check_like->num_rows > 0) {
    // Delete the like record from AnswerLikes table
    $sql_delete_like = "DELETE FROM AnswerLikes WHERE Student_id = ? AND Answer_id = ?";
    $stmt_delete_like = $conn->prepare($sql_delete_like);
    $stmt_delete_like->bind_param("ii", $student_id, $A_id);

    if ($stmt_delete_like->execute()) {
        // Update the likes count in the Answers table
        $sql_update_likes = "UPDATE Answers SET likes = likes - 1 WHERE A_id = ?";
        $stmt_update_likes = $conn->prepare($sql_update_likes);
        $stmt_update_likes->bind_param("i", $A_id);

        if ($stmt_update_likes->execute()) {
            echo "success";
        } else {
            echo "Oops! Something went wrong while updating likes.";
        }

        $stmt_update_likes->close();
    } else {
        echo "Oops! Something went wrong while unliking the answer.";
    }

    $stmt_delete_like->close();
} else {
    echo "You have unliked this answer.";
}

$stmt_check_like->close();
$conn->close();
?>
