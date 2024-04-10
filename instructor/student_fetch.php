<?php
session_start();
if (!isset($_SESSION['l_id'])) {
    header('Location:Index.php');
}
include_once("../DB_Files/db.php");

$output = '';

// Check if the instructor is logged in and retrieve their ID
if (isset($_SESSION['l_id'])) {
    $lec_id = $_SESSION['l_id'];

    // Query to retrieve courses taught by the instructor
    $course_query = "SELECT course_id, course_name FROM course WHERE lec_id = '$lec_id'";
    $course_result = mysqli_query($conn, $course_query);

    if (mysqli_num_rows($course_result) > 0) {
        while ($course_row = mysqli_fetch_assoc($course_result)) {
            $course_id = $course_row['course_id'];

            // Pagination variables
            $limit = 5; // Number of records per page
            $page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page
            $start = ($page - 1) * $limit; // Starting index for fetching records

            // Search functionality
            $search_query = isset($_GET['search']) ? $_GET['search'] : '';
            $search_condition = $search_query ? " AND stu_name LIKE '%$search_query%'" : '';

            // Query to retrieve students enrolled in the identified course with pagination and search
            $student_query = "SELECT students.stu_id, students.stu_name, students.stu_email 
                              FROM students 
                              INNER JOIN courseorder 
                              ON students.stu_email = courseorder.stu_email 
                              WHERE courseorder.course_id = '$course_id' 
                              $search_condition
                              LIMIT $start, $limit";
            $student_result = mysqli_query($conn, $student_query);

            if (mysqli_num_rows($student_result) > 0) {
                $output .= '<h3>Students enrolled in ' . $course_row['course_name'] . ':</h3>';
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
                while ($student_row = mysqli_fetch_assoc($student_result)) {
                    $output .= '<tr>';
                    $output .= '<td>' . $student_row['stu_id'] . '</td>';
                    $output .= '<td>' . $student_row['stu_name'] . '</td>';
                    $output .= '<td>' . $student_row['stu_email'] . '</td>';
                    $output .= '<td>';
                    $output .= '<form action="editStudent.php" method="POST" class="d-inline">';
                    $output .= '<input type="hidden" name="id" value="' . $student_row["stu_id"] . '">';
                    $output .= '<button type="submit" class="btn btn-info mr-2"><i class="fa fa-pencil"></i> Edit</button>';
                    $output .= '</form>';
                    $output .= '</td>';
                    $output .= '</tr>';
                }
                $output .= '</tbody>';
                $output .= '</table>';
                $output .= '</div>';

                // Pagination links
                $pagination_query = "SELECT COUNT(*) AS total 
                                     FROM students 
                                     INNER JOIN courseorder 
                                     ON students.stu_email = courseorder.stu_email 
                                     WHERE courseorder.course_id = '$course_id' 
                                     $search_condition";
                $pagination_result = mysqli_query($conn, $pagination_query);
                $pagination_row = mysqli_fetch_assoc($pagination_result);
                $total_records = $pagination_row['total'];
                $total_pages = ceil($total_records / $limit);

                $output .= '<nav aria-label="Page navigation">';
                $output .= '<ul class="pagination justify-content-center">';
                if ($page > 1) {
                    $output .= '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '&search=' . $search_query . '">Previous</a></li>';
                }
                for ($i = 1; $i <= $total_pages; $i++) {
                    $output .= '<li class="page-item ' . ($page == $i ? 'active' : '') . '"><a class="page-link" href="?page=' . $i . '&search=' . $search_query . '">' . $i . '</a></li>';
                }
                if ($page < $total_pages) {
                    $output .= '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '&search=' . $search_query . '">Next</a></li>';
                }
                $output .= '</ul>';
                $output .= '</nav>';
            } else {
                $output .= '<p>No students enrolled in ' . $course_row['course_name'] . '</p>';
                }
                }
                } else {
                $output .= '<p>No courses assigned to this instructor.</p>';
                }
                } else {
                $output .= '<p>Please log in to view students.</p>';
                }
                
                echo $output;
                
                // Close connection
                mysqli_close($conn);
                ?>
