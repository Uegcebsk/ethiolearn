<?php
include_once("../DB_Files/db.php");

$output = '';

$itemsPerPage = isset($_POST['itemsPerPage']) ? (int)$_POST['itemsPerPage'] : 5;
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$offset = ($page - 1) * $itemsPerPage;

$search_text = isset($_POST['search_text']) ? $_POST['search_text'] : '';
$course_filter = isset($_POST['course_filter']) ? $_POST['course_filter'] : '';

$sql = "SELECT students.*, course.course_name 
        FROM students 
        LEFT JOIN courseorder ON students.stu_id = courseorder.stu_id 
        LEFT JOIN course ON courseorder.course_id = course.course_id 
        WHERE 1=1 ";
if (!empty($search_text)) {
    $sql .= "AND (students.stu_name LIKE '%$search_text%' OR students.stu_email LIKE '%$search_text%') ";
}
if (!empty($course_filter)) {
    $sql .= "AND courseorder.course_id = '$course_filter' ";
}
$sql .= "LIMIT $offset, $itemsPerPage";

$result = mysqli_query($conn, $sql);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $output .= '
        <table class="table">
        <tr>
            <th class="text-dark fw-bolder">Student ID</th>
            <th class="text-dark fw-bolder">Name</th>
            <th class="text-dark fw-bolder">Email</th>
            <th class="text-dark fw-bolder">Course</th>
            <th class="text-dark fw-bolder">Action</th>
        </tr>
        ';

        while ($row = mysqli_fetch_array($result)) {
            $output .= '
            <tr>
                <td class="text-dark fw-bolder">' . $row["stu_id"] . '</td>
                <td class="text-dark fw-bolder">' . $row["stu_name"] . '</td> 
                <td class="text-dark fw-bolder">' . $row["stu_email"] . '</td>
                <td class="text-dark fw-bolder">' . $row["course_name"] . '</td>
                <td class="text-dark fw-bolder">
                    <form action="editStudent.php" method="POST" class="d-inline">
                        <input type="hidden" name="id" value="' . $row["stu_id"] . '">
                        <button type="submit" class="btn btn-info mr-3 fw-bolder">View</button>
                    </form>
                </td>
            </tr>
            ';
        }

        $output .= '</table>';

        // Pagination
        $sql = "SELECT COUNT(*) AS total 
                FROM students 
                LEFT JOIN courseorder ON students.stu_id = courseorder.stu_id 
                LEFT JOIN course ON courseorder.course_id = course.course_id 
                WHERE 1=1 ";
        if (!empty($search_text)) {
            $sql .= "AND (students.stu_name LIKE '%$search_text%' OR students.stu_email LIKE '%$search_text%') ";
        }
        if (!empty($course_filter)) {
            $sql .= "AND courseorder.course_id = '$course_filter' ";
        }
        $resultCount = mysqli_query($conn, $sql);
        $rowCount = mysqli_fetch_array($resultCount)['total'];
        $totalPages = ceil($rowCount / $itemsPerPage);
        $output .= '<ul class="pagination">';
        for ($i = 1; $i <= $totalPages; $i++) {
            $output .= '<li class="page-item"><a class="page-link pagination-link" href="#" data-page="' . $i . '">' . $i . '</a></li>';
        }
        $output .= '</ul>';
    } else {
        $output .= "<p class='text-dark p-2 fw-bolder'>No students found.</p>";
    }
} else {
    $output .= "<p class='text-dark p-2 fw-bolder'>Error in SQL query.</p>";
}

echo $output;

mysqli_close($conn);
?>
