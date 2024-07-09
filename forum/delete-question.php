<?php
// Include necessary files
include_once("../DB_Files/db.php");
include_once("../Inc/Header.php");

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['stu_id'])) {
    header("Location: /ethiolearn/Login&SignIn.php");
    exit();
}

// Get question ID from URL
$Q_id = $_GET['Q_id'];

// Delete the question from the database
$sql = "DELETE FROM questions WHERE Q_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $Q_id);

if ($stmt->execute()) {
    header("Location: my-questions.php");
    exit();
} else {
    echo "Error deleting question.";
}
?>
