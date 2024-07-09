<?php
session_start();
include_once("../DB_Files/db.php");
include_once("../Inc/Header.php");

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['stu_id'])) {
    header("Location: /ethiolearn/Login&SignIn.php");
    exit();
}

// Get student ID from session
$stu_id = $_SESSION['stu_id'];

// Construct SQL query to fetch questions answered by the specific student, including course names
$sql = "SELECT q.Q_id, q.q_body, c.course_name, q.q_timestamp, q.resolved, a.A_body, a.likes, s.stu_name AS answerer_name
        FROM questions q
        INNER JOIN course c ON q.course_id = c.course_id
        INNER JOIN answers a ON q.Q_id = a.Q_id
        LEFT JOIN students s ON a.A_stu_id = s.stu_id
        WHERE a.A_stu_id = ?
        ORDER BY q.q_timestamp DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $stu_id);
$stmt->execute();
$result = $stmt->get_result();

// Initialize an array to store questions and their answers
$questions = [];

while ($row = $result->fetch_assoc()) {
    $q_id = $row['Q_id'];
    if (!isset($questions[$q_id])) {
        $questions[$q_id] = [
            'q_body' => $row['q_body'],
            'course_name' => $row['course_name'],
            'q_timestamp' => $row['q_timestamp'],
            'resolved' => $row['resolved'],
            'answers' => []
        ];
    }
    $questions[$q_id]['answers'][] = [
        'A_body' => $row['A_body'],
        'likes' => $row['likes'],
        'answerer_name' => $row['answerer_name']
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Answers</title>
    <link rel="stylesheet" href="/ethiolearn/bootstrap/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Arial', sans-serif;
            padding-right: 10%;
        }

        .container {
            margin-top: 3%;
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

        .question-body {
            font-size: 18px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .question-info {
            font-size: 14px;
            color: #6c757d;
        }

        .answer {
            background-color: #e9ecef;
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
    </style>
</head>
<body>
    <?php include_once("menu.php"); ?>
    <div class="container">
        <div class="btn-container">
         
        </div>
        
        <?php
        // Check if any questions were found
        if (count($questions) > 0) {
            // Output questions and their answers
            foreach ($questions as $q_id => $question) {
                echo '
                <div class="question">
                    <p class="question-body">' . htmlspecialchars($question["q_body"]) . '</p>
                    <p class="question-info">Course: ' . htmlspecialchars($question["course_name"]) . '</p>
                    <p class="question-info">Timestamp: ' . htmlspecialchars($question["q_timestamp"]) . '</p>
                    <p class="question-info">Resolved: ' . ($question["resolved"] ? 'Yes' : 'No') . '</p>';

                // Display answers
                foreach ($question['answers'] as $answer) {
                    echo '
                    <div class="answer">
                        <p class="answer-body">' . htmlspecialchars($answer["A_body"]) . '</p>
                        <p class="answer-likes">Likes: ' . htmlspecialchars($answer["likes"]) . '</p>
                    </div>';
                }
                echo '</div>'; // Close question div
            }
        } else {
            echo '<p class="no-answer-msg">No questions answered by this student.</p>';
        }

        // Close database connection
        $stmt->close();
        $conn->close();
        ?>
    </div>
</body>
</html>
