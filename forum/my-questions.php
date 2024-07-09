<?php
// Include necessary files
include_once("../DB_Files/db.php");
include_once("../Inc/Header.php");

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['stu_id'])) {
    header("Location: /ethiolearn/Login&SignIn.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Questions</title>
    <link rel="stylesheet" href="/ethiolearn/bootstrap/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Arial', sans-serif;
            padding-right:10%;
        }

        .container {
            margin-top: 7%;
            max-width: 900px;
        }

        .btn-container {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }

        .question {
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .question-number {
            font-size: 20px;
            font-weight: bold;
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
        }

        .no-answer-msg {
            font-style: italic;
            color: #6c757d;
        }

        .question-actions {
            margin-top: 10px;
        }

        .rounded-circle {
            width: 50px; /* Adjust according to your design */
            height: 50px; /* Adjust according to your design */
            overflow: hidden;
            border-radius: 50%; /* Ensures the image is circular */
        }

        .rounded-circle img {
            width: 100%; /* Ensures the image fills the circular div */
            height: auto; /* Maintains aspect ratio */
            object-fit: cover; /* Covers the circular area */
        }
    </style>
</head>
<body>
    <?php include_once("menu.php"); ?>
    <div class="container">
        <div class="btn-container">
          
        </div>

        <?php
        // Get student ID from session
        $stu_id = $_SESSION['stu_id'];

        // Construct SQL query to fetch questions submitted by the specific student
        $sql = "SELECT q.Q_id, q.q_body, q.course_id, q.q_timestamp, q.resolved, s.stu_img
                FROM questions q 
                LEFT JOIN students s ON q.q_stu_id = s.stu_id
                WHERE q.q_stu_id = ?
                ORDER BY q.q_timestamp DESC";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $stu_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if any results were found
        if ($result->num_rows > 0) {
            $question_number = 1;
            // Output questions and answers
            while ($row = $result->fetch_assoc()) {
                // Display question
                echo '
                <div class="question">
                    <p class="question-number">Question ' . $question_number . '</p>
                    <p class="question-body">' . htmlspecialchars($row["q_body"]) . '</p>';

                // Fetch answers for the current question
                $Q_id = $row['Q_id'];
                $answer_sql = "SELECT a.A_id, a.A_body, a.likes, s.stu_name AS answerer_name
                               FROM answers a
                               LEFT JOIN students s ON a.A_stu_id = s.stu_id
                               WHERE a.Q_id = ?
                               ORDER BY a.A_id ASC";
                
                $answer_stmt = $conn->prepare($answer_sql);
                $answer_stmt->bind_param("i", $Q_id);
                $answer_stmt->execute();
                $answer_result = $answer_stmt->get_result();

                // Check if any answers were found
                if ($answer_result->num_rows > 0) {
                    while ($answer_row = $answer_result->fetch_assoc()) {
                        echo '
                        <div class="answer">
                            <p class="answer-body">' . htmlspecialchars($answer_row["A_body"]) . '</p>';
                        
                        // Display student image if available
                        if (!empty($row['stu_img'])) {
                            echo '
                            <div class="rounded-circle">
                                <img src="' . htmlspecialchars($row["stu_img"]) . '" alt="Student Image" class="img-fluid">
                            </div>';
                        }

                        echo '
                            <p class="answer-info">Answered by: ' . htmlspecialchars($answer_row["answerer_name"]) . '</p>
                            <p class="answer-likes">Likes: ' . $answer_row["likes"] . '</p>
                        </div>';
                    }
                } else {
                    echo '<p class="no-answer-msg">No answers yet for this question.</p>';
                }

                // Display action buttons for editing and deleting questions
                echo '
                <div class="question-actions">
                    <a href="edit-question.php?Q_id=' . $row["Q_id"] . '" class="btn btn-info btn-sm"><i class="fas fa-edit"></i> Edit</a>
                    <a href="delete-question.php?Q_id=' . $row["Q_id"] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this question?\');"><i class="fas fa-trash-alt"></i> Delete</a>
                </div>';

                echo '</div>'; // Close question div

                $question_number++;
            }
        } else {
            // Display message if no questions were found
            echo "<p>No questions found for this student.</p>";
        }

        // Close database connection
        $conn->close();
        ?>
    </div>
  
</body>
</html>
