<?php
include_once("../DB_Files/db.php");
include_once("../Inc/Header.php");

$qid = $_POST['Q_id'];
$sql = "SELECT Q_id, q.Q_stu_id, q.q_body, q.course_id, q.q_timestamp, q.resolved, c.course_name, s.stu_name, stu_img
FROM questions q 
JOIN course c ON q.course_id = c.course_id
JOIN students s ON q.Q_stu_id = s.stu_id
WHERE Q_id = " . $qid;

$result1 = $conn->query($sql);
if ($result1->num_rows > 0) {
    while ($row = $result1->fetch_assoc()) {
        echo '
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow mb-3">
                    <div class="card-body">
                        <p class="card-text"><a href="#" style="color: blue; font-weight: bold;">' . $row["q_body"] . '?</a></p>
                        <p class="card-text">Course Name: ' . $row["course_name"] . '</p>
                    </div>
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle overflow-hidden" style="width: 50px; height: 50px; margin-right: 10px;">
                            <img src="' . $row["stu_img"] . '" alt="Student Image" class="img-fluid rounded-circle">
                        </div>
                        <div>
                            <p class="mb-0 text-muted">' . $row["q_timestamp"] . '</p>
                            <p class="mb-1"><strong>' . $row["stu_name"] . '</strong></p>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Resolved: ' . $row["resolved"] . '</p>
                        <form name="form2" method="POST" action="expand-question.php">
                            <input type="submit" name="Q_id" class="btn btn-link" style="width: 300px;" value="' . $row["Q_id"] . '">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>';
    }
} else {
    echo "<div class='container'><p>No question with this qid</p></div>";
}

$sql2 = "SELECT A_id, A_body, likes, a_timestamp, s.stu_name,s.stu_img 
         FROM Answers a
         JOIN students s ON a.A_stu_id = s.stu_id
         WHERE a.Q_id = $qid
         ORDER BY a.a_timestamp DESC";
$result2 = $conn->query($sql2);

if ($result2->num_rows > 0) {
    // Output answers
    echo '<div class="container mb-4">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h5 class="card-title">Answers</h5>';

    while ($row = $result2->fetch_assoc()) {
        echo '
        <div class="card mb-3">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-circle overflow-hidden" style="width: 50px; height: 50px; margin-right: 10px;">
                    <img src="' . $row["stu_img"] . '" alt="Student Image" class="img-fluid rounded-circle">
                </div>
                <div>
                    <p class="mb-1"><strong>' . $row["stu_name"] . '</strong></p>
                    <p class="mb-0 text-muted">' . $row["a_timestamp"] . '</p>
                </div>
            </div>
            <div class="card-body">
                <p class="card-text">A_id: ' . $row["A_id"] . '</p>
                <p class="card-text">Answer: ' . $row["A_body"] . '</p>
                <p class="card-text">Likes: ' . $row["likes"] . '</p>
                <form name="form2" method="POST" action="like-answer.php">
                    <button type="submit" name="A_id" class="btn btn-success" value="' . $row["A_id"] . '">
                        <i class="fas fa-thumbs-up"></i> Like
                    </button>
                </form>
            </div>
        </div>';
    }

    echo '</div></div></div>';
} else {
    echo "<div class='container'><p>0 answers for this question</p></div>";
}

$_SESSION["qid"] = $qid;
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font: 14px sans-serif;
            text-align: center;
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .card-body {
            padding: 1.25rem;
        }

        .rounded-circle {
            overflow: hidden;
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }

        .img-fluid {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .btn-success i {
            margin-right: 5px;
        }

        a.card-link {
            color: blue;
            font-weight: bold;
        }

        a.card-link:hover {
            text-decoration: none;
        }
    </style>
</head>
<body>
    <form name="form1" method="POST" action="post-answer.php">
        <input type="text" value="Enter Answer Body" name="A_body">
        <input type="submit" name="Submit1" class="btn btn-primary" value="Submit">
    </form>

</body>
</html>
