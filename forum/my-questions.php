<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        
        .btn-container {
            margin-bottom: 20px;
        }
        
        .question {
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .question-body {
            font-size: 18px;
            margin-bottom: 10px;
        }
        
        .answer {
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 10px;
            margin-top: 10px;
        }
        
        .answer-body {
            font-size: 16px;
            margin-bottom: 5px;
        }
        
        .answer-likes {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 0;
        }
        
        .no-answer-msg {
            font-style: italic;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="btn-container">
            <a href="forum.php" class="btn btn-warning"><i class="fas fa-comments"></i> Main Forum</a>
            <a href="post-question.php" class="btn btn-warning"><i class="fas fa-plus"></i> Post Question</a>
            <a href="my-questions.php" class="btn btn-warning"><i class="fas fa-question-circle"></i> Your Questions</a>
            <a href="my-answers.php" class="btn btn-warning"><i class="fas fa-check-circle"></i> Your Answers</a>
        </div>
        
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

// Construct SQL query to fetch questions submitted by the specific student
$sql = "SELECT q.Q_id, q.q_body, q.course_id, q.q_timestamp, q.resolved, a.A_id, a.A_body, a.likes, s.stu_name AS answerer_name
        FROM questions q 
        LEFT JOIN answers a ON q.Q_id = a.Q_id
        LEFT JOIN students s ON a.A_stu_id = s.stu_id
        WHERE q.q_stu_id = $stu_id
        ORDER BY q.q_timestamp DESC";

$result = $conn->query($sql);

// Check if any results were found
if ($result->num_rows > 0) {
    // Output questions and answers
    while ($row = $result->fetch_assoc()) {
        // Display question
        echo '
        <div class="question">
            <p class="question-body">' . $row["q_body"] . '</p>';

        // Display answer if available
        if ($row["A_id"]) {
            echo '
            <div class="answer">
                <p class="answer-body">' . $row["A_body"] . '</p>
                <p class="answer-info">Answered by: ' . $row["answerer_name"] . '</p>
                <p class="answer-likes">Likes: ' . $row["likes"] . '</p>
            </div>';
        } else {
            echo '<p class="no-answer-msg">No answers yet for this question.</p>';
        }

        echo '</div>'; // Close question div
    }
} else {
    // Display message if no questions were found
    echo "<p>No questions found for this student.</p>";
}

// Close database connection
$conn->close();
?>

</body>
</html>
