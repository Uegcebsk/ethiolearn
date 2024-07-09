<?php
session_start();
if (!isset($_SESSION['l_id'])) {
    header('Location:Index.php');
    exit(); // Add exit to stop script execution
}
include_once("../DB_Files/db.php");

$output = '';

$search_text = isset($_POST['search_text']) ? $_POST['search_text'] : '';
$course_filter = isset($_POST['course_filter']) ? $_POST['course_filter'] : '';
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$items_per_page = isset($_POST['items_per_page']) ? (int)$_POST['items_per_page'] : 5;
$offset = ($page - 1) * $items_per_page;

$sql = "SELECT students.stu_id, students.stu_name, students.stu_email, students.email_verified
        FROM students 
        INNER JOIN courseorder ON students.stu_id = courseorder.stu_id 
        WHERE 1=1 AND students.email_verified=1 ";

// If a specific course is selected, filter by that course
if (!empty($course_filter)) {
    $sql .= "AND courseorder.course_id = '$course_filter' ";
} else {
    // If no course is selected, filter by courses taught by the lecturer
    $lec_id = $_SESSION['l_id'];
    $sql .= "AND courseorder.course_id IN (SELECT course_id FROM course WHERE lec_id = '$lec_id') ";
}

if (!empty($search_text)) {
    // Search by student name or email
    $sql .= "AND (students.stu_name LIKE '%$search_text%' OR students.stu_email LIKE '%$search_text%') ";
}

// Add pagination
$count_query = "SELECT COUNT(*) AS total 
                FROM students 
                INNER JOIN courseorder ON students.stu_id = courseorder.stu_id 
                WHERE 1=1 ";
if (!empty($course_filter)) {
    $count_query .= "AND courseorder.course_id = '$course_filter' ";
} else {
    $count_query .= "AND courseorder.course_id IN (SELECT course_id FROM course WHERE lec_id = '$lec_id') ";
}
if (!empty($search_text)) {
    $count_query .= "AND (students.stu_name LIKE '%$search_text%' OR students.stu_email LIKE '%$search_text%') ";
}
$result_count = mysqli_query($conn, $count_query);
$total_records = mysqli_fetch_assoc($result_count)['total'];
$total_pages = ceil($total_records / $items_per_page);

$sql .= "LIMIT $offset, $items_per_page";

$result = mysqli_query($conn, $sql);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $output .= '<div class="table-responsive">';
        $output .= '<table class="table table-bordered table-striped">';
        $output .= '<thead class="thead-dark">';
        $output .= '<tr>';
        $output .= '<th>Student ID</th>';
        $output .= '<th>Name</th>';
        $output .= '<th>Email</th>';
        $output .= '<th>Action</th>';
        $output .= '</tr>';
        $output .= '</thead>';
        $output .= '<tbody>';
        while ($row = mysqli_fetch_assoc($result)) {
            $output .= '<tr>';
            $output .= '<td>' . $row['stu_id'] . '</td>';
            $output .= '<td>' . $row['stu_name'] . '</td>';
            $output .= '<td>' . $row['stu_email'] . '</td>';
            $output .= '<td>';
            $output .= '<form action="editStudent.php" method="POST" class="d-inline">';
            $output .= '<input type="hidden" name="id" value="' . $row["stu_id"] . '">';
            $output .= '<button type="submit" class="btn btn-info mr-2"><i class="fa fa-pencil"></i> Edit</button>';
            $output .= '</form>';
            $output .= '</td>';
            $output .= '</tr>';
        }
        $output .= '</tbody>';
        $output .= '</table>';
        $output .= '</div>';

        // Pagination links
        $output .= '<nav aria-label="Page navigation">';
        $output .= '<ul class="pagination justify-content-center">';
        for ($i = 1; $i <= $total_pages; $i++) {
            $output .= '<li class="page-item ' . ($page == $i ? 'active' : '') . '"><a class="page-link pagination-link" href="#" data-page="' . $i . '">' . $i . '</a></li>';
        }
        $output .= '</ul>';
        $output .= '</nav>';
    } else {
        $output .= "<p class='text-dark p-2 fw-bolder'>No students found.</p>";
    }
} else {
    $output .= "<p class='text-dark p-2 fw-bolder'>Error in SQL query.</p>";
}

echo $output;

mysqli_close($conn);
?>
