<?php
session_start(); // Start the session
include_once("../DB_Files/db.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['stu_id'])) {
    // Validate if the answer is not empty and within the character limit
    $answer = trim($_POST["answer"]);
    if (empty($answer)) {
        echo "Answer field is empty.";
    } elseif (strlen($answer) < 10 || strlen($answer) > 200) {
        echo "Answer must be between 10 and 100 characters.";
    } else {
        // Retrieve Q_id and answer from the form
        $qid = $_POST['Q_id'];
        $stu_id = $_SESSION['stu_id']; // Retrieve student ID from session

        // Prepare and execute SQL to insert the answer into the database
        $stmt = $conn->prepare("INSERT INTO Answers (Q_id, A_body, A_stu_id, likes) VALUES (?, ?, ?, 0)");
        $stmt->bind_param("iss", $qid, $answer, $stu_id);

        if ($stmt->execute()) {
            echo "success"; // Send success message back to the AJAX request
        } else {
            echo "Error submitting answer. Please try again.";
        }

        // Close statement
        $stmt->close();
    }
}

$conn->close();
?>
