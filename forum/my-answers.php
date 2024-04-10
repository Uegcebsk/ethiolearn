<?php
session_start();
include_once("../DB_Files/db.php");

// Check if student ID is set in session
if (!isset($_SESSION['stu_id'])) {
    header("Location: Login&SignIn.php");
    exit();
}

// Get student ID from session
$stu_id = $_SESSION['stu_id'];

// Construct SQL query to fetch questions answered by the specific student
$sql = "SELECT q.Q_id, q.q_body, q.course_id, q.q_timestamp, q.resolved
        FROM questions q 
        INNER JOIN answers a ON q.Q_id = a.Q_id
        WHERE a.A_stu_id = $stu_id
        ORDER BY q.q_timestamp DESC";

$result = $conn->query($sql);

// Check if any results were found
if ($result->num_rows > 0) {
    // Output questions
    while ($row = $result->fetch_assoc()) {
        // Display question
        echo '
        <div class="question">
            <p class="question-body">' . $row["q_body"] . '</p>
            <p class="question-info">Course ID: ' . $row["course_id"] . '</p>
            <p class="question-info">Timestamp: ' . $row["q_timestamp"] . '</p>
            <p class="question-info">Resolved: ' . $row["resolved"] . '</p>
        </div>';
    }
} else {
    // Display message if no questions were found
    echo "<p>No questions answered by this student.</p>";
}

// Close database connection
$conn->close();
?>
