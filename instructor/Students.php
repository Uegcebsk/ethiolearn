<?php
include_once("../DB_Files/db.php");
include_once("header copy.php");

// Assuming $l_id holds the ID of the intended instructor
$l_id = $_SESSION['l_id']; // Assuming you store the logged-in instructor's ID in session

// Retrieve the list of courses taught by the instructor
$sql_select_courses = "SELECT * FROM course WHERE lec_id = ?";
$stmt_select_courses = $conn->prepare($sql_select_courses);
$stmt_select_courses->bind_param("i", $l_id);
$stmt_select_courses->execute();
$result_select_courses = $stmt_select_courses->get_result();

// Check if the instructor teaches more than one course
$num_courses = $result_select_courses->num_rows;

// Default course selection behavior
if ($num_courses == 1) {
    $row = $result_select_courses->fetch_assoc();
    $selected_course_id = $row['course_id'];
} else {
    // If the instructor teaches more than one course, set default course selection to none
    $selected_course_id = null;
}

if (isset($_POST['course_id'])) {
    $selected_course_id = $_POST['course_id'];
}

// Pagination settings
$itemsPerPage = isset($_GET['itemsPerPage']) ? (int)$_GET['itemsPerPage'] : 5; // Default items per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
$offset = ($page - 1) * $itemsPerPage; // Calculate offset

// Retrieve students enrolled in the selected course
if ($selected_course_id) {
    if (isset($_POST['search_text'])) {
        $search_text = $_POST['search_text'];
        $sql_select_students = "SELECT students.stu_id, students.stu_name, students.stu_email, course.course_name 
                                FROM students 
                                INNER JOIN courseorder 
                                ON students.stu_email = courseorder.stu_email 
                                INNER JOIN course 
                                ON courseorder.course_id = course.course_id 
                                WHERE course.lec_id = ? 
                                AND course.course_id = ?
                                AND students.stu_name LIKE '%$search_text%'
                                ORDER BY students.stu_id ASC
                                LIMIT $offset, $itemsPerPage";
    } else {
        $sql_select_students = "SELECT students.stu_id, students.stu_name, students.stu_email, course.course_name 
                                FROM students 
                                INNER JOIN courseorder 
                                ON students.stu_email = courseorder.stu_email 
                                INNER JOIN course 
                                ON courseorder.course_id = course.course_id 
                                WHERE course.lec_id = ? 
                                AND course.course_id = ?
                                ORDER BY students.stu_id ASC
                                LIMIT $offset, $itemsPerPage";
    }
    $stmt_select_students = $conn->prepare($sql_select_students);
    $stmt_select_students->bind_param("ii", $l_id, $selected_course_id);
    $stmt_select_students->execute();
    $result_select_students = $stmt_select_students->get_result();

    // Count total students for pagination
    if (isset($_POST['search_text'])) {
        $sql_count_students = "SELECT COUNT(*) AS total 
                               FROM students 
                               INNER JOIN courseorder 
                               ON students.stu_email = courseorder.stu_email 
                               INNER JOIN course 
                               ON courseorder.course_id = course.course_id 
                               WHERE course.lec_id = ? 
                               AND course.course_id = ?
                               AND students.stu_name LIKE '%$search_text%'";
    } else {
        $sql_count_students = "SELECT COUNT(*) AS total 
                               FROM students 
                               INNER JOIN courseorder 
                               ON students.stu_email = courseorder.stu_email 
                               INNER JOIN course 
                               ON courseorder.course_id = course.course_id 
                               WHERE course.lec_id = ? 
                               AND course.course_id = ?";
    }
    $stmt_count_students = $conn->prepare($sql_count_students);
    $stmt_count_students->bind_param("ii", $l_id, $selected_course_id);
    $stmt_count_students->execute();
    $totalStudentsRow = $stmt_count_students->get_result()->fetch_assoc();
    $totalStudents = $totalStudentsRow['total'];
    $totalPages = ceil($totalStudents / $itemsPerPage);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
    <link rel="stylesheet" href="/ethiolearn/CSS.all.min.css">
    <link rel="stylesheet" href="css/material.css"> <!-- Ensure the same CSS file as material.php -->
    <link rel="stylesheet" href="/ethiolearn/Font awesome/all.min.css">
</head>
<style>
.student-list table td{
    color:black;
}
.container{
    padding: 3%;
}
</style>
<body>
    <div class="container">
        <h2>Student Management</h2>
        <div class="search-bar">
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <?php if ($num_courses > 1) : ?>
                        <div class="input-group mb-3">
                        <select name="course_id" class="form-select">
                            <?php while ($course = $result_select_courses->fetch_assoc()) : ?>
                                <option value="<?php echo $course['course_id']; ?>" <?php if ($selected_course_id == $course['course_id']) echo 'selected'; ?>><?php echo $course['course_name']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary">Search</button>
                    </div>
            </form>
        </div>
        <div class="input-group mb-2">
        <?php if (isset($_POST['course_id']) || $selected_course_id) : ?>
                <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="input-group mb-3">
                <div class="item-per-page-selection">
                    <select name="itemsPerPage" class="form-select">
                        <option value="5" <?php if ($itemsPerPage == 5) echo 'selected'; ?>>5 per page</option>
                        <option value="10" <?php if ($itemsPerPage == 10) echo 'selected'; ?>>10 per page</option>
                        <option value="20" <?php if ($itemsPerPage == 20) echo 'selected'; ?>>20 per page</option>
                    </select>
                    <input type="hidden" name="course_id" value="<?php echo $selected_course_id; ?>">
                    <button type="submit" class="btn btn-primary">Apply</button>
                    </div>
                    <input type="text" class="form-control" id="search_text" name="search_text" placeholder="Student Name" value="<?php echo isset($_POST['search_text']) ? $_POST['search_text'] : ''; ?>">
                    </div>
                </form>
            </div>
            <?php if ($selected_course_id && $result_select_students->num_rows > 0) : ?>
                <div class="student-list">
                    <table>
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Email</th>
                                <th>Course Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result_select_students->fetch_assoc()) : ?>
                                <tr>
                                    <td><?php echo $row['stu_name']; ?></td>
                                    <td><?php echo $row['stu_email']; ?></td>
                                    <td><?php echo $row['course_name']; ?></td>
                                    <td class="material-actions">
                                        <a href="editstudent.php?stu_id=<?php echo $row['stu_id']; ?>"><i class="fas fa-edit"></i> Edit</a>
                                        <a href="deletestudent.php?stu_id=<?php echo $row['stu_id']; ?>" onclick="return confirm('Are you sure you want to delete this student?')"><i class="fas fa-trash-alt"></i> Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="pagination">
                    <?php if ($totalPages > 1) : ?>
                        <a href="?page=1&itemsPerPage=<?php echo $itemsPerPage; ?>&course_id=<?php echo $selected_course_id; ?>">&laquo; First</a>
                        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                            <a href="?page=<?php echo $i; ?>&itemsPerPage=<?php echo $itemsPerPage; ?>&course_id=<?php echo $selected_course_id; ?>" class="<?php echo $i == $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
                        <?php endfor; ?>
                        <a href="?page=<?php echo $totalPages; ?>&itemsPerPage=<?php echo $itemsPerPage; ?>&course_id=<?php echo $selected_course_id; ?>">Last &raquo;</a>
                    <?php endif; ?>
                </div>
            <?php else : ?>
                <p>No students enrolled in this course.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <script>
        $(document).ready(function(){
            $('#search_text').keyup(function(){
                var txt = $(this).val();
                var selectedCourseId = $('select[name="course_id"]').val();
                $.ajax({
                    url: "<?php echo $_SERVER['PHP_SELF']; ?>",
                    type: "post",
                    data: {search_text: txt, course_id: selectedCourseId},
                    dataType: "html",
                    success: function (data) {
                        $('.student-list tbody').html($(data).find('.student-list tbody').html());
                        $('.pagination').html($(data).find('.pagination').html());
                    }
                });
            });
        });
    </script>
</body>
</html>
