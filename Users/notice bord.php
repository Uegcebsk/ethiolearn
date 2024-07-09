<?php
include_once("ProfileHeader.php");
include_once("../DB_Files/db.php");
if (!isset($_SESSION['stu_id'])) {
    // Redirect to the login page if not logged in
    header("Location: index.php");
    exit();
}
$student_id = $_SESSION['stu_id'];

// Step 1: Retrieve Courses Enrolled by the Student
$sql_courses = "SELECT course_id FROM courseorder WHERE stu_id = ?";
$stmt_courses = $conn->prepare($sql_courses);
$stmt_courses->bind_param("i", $student_id);
$stmt_courses->execute();
$result_courses = $stmt_courses->get_result();

// Prepare an array to store course IDs
$course_ids = [];
while ($row_course = $result_courses->fetch_assoc()) {
    $course_ids[] = $row_course['course_id'];
}

// Step 2: Retrieve Notices for Enrolled Courses
if (!empty($course_ids)) {
    $placeholders = str_repeat('?, ', count($course_ids) - 1) . '?';
    $sql_notices = "SELECT * FROM notices WHERE course_id IN ($placeholders)";
    $stmt_notices = $conn->prepare($sql_notices);
    $stmt_notices->bind_param(str_repeat('i', count($course_ids)), ...$course_ids);
    $stmt_notices->execute();
    $result_notices = $stmt_notices->get_result();
}
?>

<div class="container" style="padding-left:6%; margin-top:5%;">
    <h2>Notice Board</h2>
    <div class="row">
        <?php if (!empty($result_notices)) { ?>
            <?php while ($row_notice = $result_notices->fetch_assoc()) { ?>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row_notice['title']; ?></h5>
                            <a href="noticebords.php?id=<?php echo $row_notice['notice_id']; ?>" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="col-md-12">
                <div class="alert alert-info">No notices found for your enrolled courses.</div>
            </div>
        <?php } ?>
    </div>
</div>

<?php

?>
