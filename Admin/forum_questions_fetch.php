<?php
include_once("../DB_Files/db.php");

$search_text = $_POST['search_text'] ?? '';
$course_filter = $_POST['course_filter'] ?? '';
$itemsPerPage = $_POST['itemsPerPage'] ?? 5;
$page = $_POST['page'] ?? 1;

$offset = ($page - 1) * $itemsPerPage;

$sql = "SELECT q.Q_id, q.q_body, c.course_name, q.q_timestamp, q.resolved, s.stu_name, COUNT(a.A_id) as answer_count
        FROM questions q
        INNER JOIN course c ON q.course_id = c.course_id
        INNER JOIN students s ON q.q_stu_id = s.stu_id
        LEFT JOIN answers a ON q.Q_id = a.Q_id
        WHERE s.stu_name LIKE ? 
        AND (c.course_id LIKE ? OR ? = '')
        GROUP BY q.Q_id, q.q_body, c.course_name, q.q_timestamp, q.resolved, s.stu_name
        ORDER BY q.q_timestamp DESC
        LIMIT ?, ?";

$stmt = $conn->prepare($sql);
$search_text = "%" . $search_text . "%";
$course_filter = $course_filter ?: '%';

$stmt->bind_param("sssii", $search_text, $course_filter, $course_filter, $offset, $itemsPerPage);
$stmt->execute();
$result = $stmt->get_result();

$total_sql = "SELECT COUNT(*) AS total
              FROM questions q
              INNER JOIN course c ON q.course_id = c.course_id
              INNER JOIN students s ON q.q_stu_id = s.stu_id
              WHERE s.stu_name LIKE ? 
              AND (c.course_id LIKE ? OR ? = '')";
$total_stmt = $conn->prepare($total_sql);
$total_stmt->bind_param("sss", $search_text, $course_filter, $course_filter);
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_row = $total_result->fetch_assoc();
$total_items = $total_row['total'];
$total_pages = ceil($total_items / $itemsPerPage);

if ($result->num_rows > 0) {
    echo '<div class="table-responsive">';
    echo '<table class="table table-bordered">';
    echo '<thead class="thead-light">';
    echo '<tr>';
    echo '<th>Student Name</th>';
    echo '<th>queston</th>';
    echo '<th>Course</th>';
    echo '<th>Timestamp</th>';
    echo '<th>Resolved</th>';
    echo '<th>Answers</th>';
    echo '<th>Actions</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row["stu_name"]) . '</td>';
        echo '<td>' . htmlspecialchars($row["q_body"]) . '</td>';
        echo '<td>' . htmlspecialchars($row["course_name"]) . '</td>';
        echo '<td>' . htmlspecialchars($row["q_timestamp"]) . '</td>';
        echo '<td>' . ($row["resolved"] ? 'Yes' : 'No') . '</td>';
        echo '<td>' . $row["answer_count"] . '</td>';
        echo '<td>
                <button class="btn btn-danger delete-question" data-id="' . $row["Q_id"] . '">Delete</button>
              </td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';

    echo '<nav aria-label="Page navigation example">';
    echo '<ul class="pagination justify-content-center">';
    for ($i = 1; $i <= $total_pages; $i++) {
        echo '<li class="page-item' . ($i == $page ? ' active' : '') . '"><a class="page-link pagination-link" href="#" data-page="' . $i . '">' . $i . '</a></li>';
    }
    echo '</ul>';
    echo '</nav>';
} else {
    echo '<p>No questions found.</p>';
}

$stmt->close();
$conn->close();
?>
