<?php
session_start();
include_once("../DB_Files/db.php");

// Get the student ID from the session
$student_id = $_SESSION['stu_id'];

// Get the answer ID from the AJAX request
$A_id = $_POST['A_id'];

// Check if the student is the author of the answer
$sql_check_author = "SELECT A_stu_id FROM Answers WHERE A_id = ?";
$stmt_check_author = $conn->prepare($sql_check_author);
$stmt_check_author->bind_param("i", $A_id);
$stmt_check_author->execute();
$stmt_check_author->store_result();

if ($stmt_check_author->num_rows > 0) {
    // Answer exists, check if the author is the current student
    $stmt_check_author->bind_result($author_id);
    $stmt_check_author->fetch();

    if ($author_id == $student_id) {
        // Student is the author, prevent liking
        echo "You cannot like your own answer.";
    } else {
        // Check if the student has already liked this answer
        $sql_check_like = "SELECT * FROM AnswerLikes WHERE Student_id = ? AND Answer_id = ?";
        $stmt_check_like = $conn->prepare($sql_check_like);
        $stmt_check_like->bind_param("ii", $student_id, $A_id);
        $stmt_check_like->execute();
        $stmt_check_like->store_result();

        if ($stmt_check_like->num_rows > 0) {
            echo "You have already liked this answer.";
        } else {
            // Insert the like into AnswerLikes table
            $sql_insert_like = "INSERT INTO AnswerLikes (Student_id, Answer_id) VALUES (?, ?)";
            $stmt_insert_like = $conn->prepare($sql_insert_like);
            $stmt_insert_like->bind_param("ii", $student_id, $A_id);

            if ($stmt_insert_like->execute()) {
                // Update the likes count in the Answers table
                $sql_update_likes = "UPDATE Answers SET likes = likes + 1 WHERE A_id = ?";
                $stmt_update_likes = $conn->prepare($sql_update_likes);
                $stmt_update_likes->bind_param("i", $A_id);

                if ($stmt_update_likes->execute()) {
                    echo "success";
                } else {
                    echo "Oops! Something went wrong while updating likes.";
                }

                $stmt_update_likes->close();
            } else {
                echo "Oops! Something went wrong while liking the answer.";
            }

            $stmt_insert_like->close();
        }
    }
} else {
    echo "Answer not found.";
}

$stmt_check_author->close();
$conn->close();
?>
