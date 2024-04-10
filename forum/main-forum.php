<?php
include_once("Header.php");
include_once("../DB_Files/db.php");



// Display all questions and answers within a subtopic
if (!empty($course_id)) {
    $sql = "Select Q_id, title, q_body, course_id, q_timestamp, resolved from questions where course_name = '" . $course_id . "'";
    $result1 = $mysqli->query($sql);
    if ($result1->num_rows > 0) {
        echo '<div class="container mt-3">';
        while ($row = $result1->fetch_assoc()) {
            echo '
            <div class="card shadow mb-3">
                <div class="card-body">
                    <h5 class="card-title">Q_id: ' . $row["Q_id"] . '</h5>
                    <form name="form2" method="POST" action="expand-question.php">
                        <input type="submit" name="Q_id" class="btn btn-link" style="width: 300px;" value="' . $row["Q_id"] . '">
                    </form>
                    <p class="card-text">Title: ' . $row["title"] . '</p>
                    <p class="card-text">Body: ' . $row["q_body"] . '</p>
                    <p class="card-text">course_name: ' . $row["course_id"] . '</p>
                    <p class="card-text">Timestamp: <span class="text-muted">' . $row["q_timestamp"] . '</span></p>
                    <p class="card-text">Resolved: ' . $row["resolved"] . '</p>
                </div>
            </div>';
        }
        echo '</div>';
    } else {
        echo "No questions under this topic";
    }
}



$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font: 14px sans-serif;
            text-align: center;
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>
</body>
</html>
