<?php
// Include necessary files and connect to the database
include_once("../DB_Files/db.php");

// Get instructor ID (assuming instructor is logged in)
$instructor_id = $_SESSION['l_id'];

// Fetch students' lesson progress for all courses taught by the instructor
$sql = "SELECT c.course_name, s.stu_id AS student_id, s.stu_name AS student_name, AVG(lp.progress) AS lesson_progress
        FROM students s
        INNER JOIN courseorder co ON s.stu_id = co.stu_id
        INNER JOIN course c ON co.course_id = c.course_id
        LEFT JOIN lesson_progress lp ON s.stu_id = lp.student_id AND c.course_id = lp.course_id
        WHERE c.lec_id = ?
        GROUP BY c.course_name, s.stu_id, s.stu_name";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $instructor_id);
$stmt->execute();
$result = $stmt->get_result();

// Prepare data for DataTables
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode(array("data" => $data));
?>
