<?php
// Include database connection
include_once("../DB_Files/db.php");

// Initialize variables for search and course filter
$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
$course = isset($_POST['course']) ? $_POST['course'] : '';

// Construct the SQL query based on search and course filter
$sql_conditions = [];
if (!empty($keyword)) {
    $sql_conditions[] = "(q.q_body LIKE '%$keyword%')";
}
if (!empty($course)) {
    $sql_conditions[] = "(c.course_name = '$course')";
}

$sql_condition = implode(" AND ", $sql_conditions);
$sql_questions = "SELECT Q_id, q.Q_stu_id, q.q_body, q.course_id, q.q_timestamp, q.resolved, c.course_name, s.stu_name, stu_img 
FROM questions q 
JOIN course c ON q.course_id = c.course_id 
JOIN students s ON q.Q_stu_id = s.stu_id 
WHERE $sql_condition";
$result_questions = $conn->query($sql_questions);

// Check if any results were found
if ($result_questions->num_rows > 0) {
    // Fetch and display search results
    while ($row = $result_questions->fetch_assoc()) {
        $resolved_class = $row["resolved"] ? "resolved" : "";
        echo '
        <div class="card '.$resolved_class.'">
            <div class="card-body">
                <p class="card-text"><a href="#" style="color: blue; font-weight: bold;">' . $row["q_body"] . '?</a></p>
                <p class="card-text">Course Name: ' . $row["course_name"] . '</p>
                <div class="d-flex align-items-center">
                    <div class="rounded-circle overflow-hidden" style="width: 50px; height: 50px; margin-right: 10px;">
                        <img src="' . $row["stu_img"] . '" alt="Student Image" class="img-fluid rounded-circle">
                    </div>
                    <div>
                        <p class="mb-0 text-muted">' . $row["q_timestamp"] . '</p>
                        <p class="mb-1"><strong>' . $row["stu_name"] . '</strong></p>
                    </div>
                </div>
                <form name="form2" method="POST" action="expand-question.php">
                    <input type="hidden" name="Q_id" value="' . $row["Q_id"] . '">
                    <button type="submit" class="btn btn-primary mt-3">Show More</button>
                </form>
            </div>
        </div>';
    }
} else {
    // Display message if no results were found
    echo "<p>No questions found.</p>";
}

// Close database connection
$conn->close();
?>
