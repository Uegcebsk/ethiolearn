<?php
include_once("Header copy.php");
include_once("../DB_Files/db.php");

$instructor_id = $_SESSION['l_id'];

$sql = "SELECT * FROM course WHERE lec_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $instructor_id);
$stmt->execute();
$result_courses = $stmt->get_result();
?>

<style>
    /* Add your custom CSS here */
    .card {
        border: 2px solid orange; /* Ethiopian flag colors */
        border-radius: 15px;
        transition: all 0.3s;
    }
    .card:hover {
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transform: translateY(-5px);
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: bold;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .table th,
    .table td {
        padding: 0.75rem;
        vertical-align: middle;
    }

    .table thead th {
        vertical-align: bottom;
        border-bottom: 2px solid #dee2e6;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.05);
    }

    .table-striped tbody tr:nth-of-type(even) {
        background-color: rgba(0, 0, 0, 0.1);
    }
</style>

<div class="container mt-5" style="padding:6%;">
    <h2 class="mb-4">Courses Taught by You</h2>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
        <?php while ($course = $result_courses->fetch_assoc()) { ?>
            <div class="col">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title"><?php echo $course['course_name']; ?></h5>
                            <ul class="list-unstyled mb-3">
                                <li><i class="fas fa-book-open me-2"></i>Lessons: <?php echo getLessonCount($conn, $course['course_id']); ?></li>
                                <li><i class="fas fa-tasks me-2"></i>Exams: <?php echo getAssessmentCount($conn, $course['course_id'], 'exam'); ?></li>
                                <li><i class="fas fa-question me-2"></i>Quizzes: <?php echo getAssessmentCount($conn, $course['course_id'], 'quiz'); ?></li>
                            </ul>
                        </div>
                        <div>
                            <a href="Course.php" class="btn btn-primary btn-sm">View More <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title">Students Enrolled</h5>
                            <p class="card-text mb-2">Total: <?php echo getStudentCount($conn, $course['course_id']); ?></p>
                            <p class="card-text mb-0">Certified: <?php echo getCertifiedStudentCount($conn, $course['course_id']); ?></p>
                        </div>
                        <div>
                            <a href="Students.php" class="btn btn-primary btn-sm">View Students <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<div class="container mt-5"style="padding-left:6%;">
    <?php
    $result_courses->data_seek(0);

    while ($course = $result_courses->fetch_assoc()) { ?>
        <div class="row">
            <div class="col">
                <h3 class="mb-4">Student Lesson Progress for <?php echo $course['course_name']; ?></h3>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Lesson Progress (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_students = "SELECT DISTINCT s.stu_id, s.stu_name FROM students s
                                INNER JOIN courseorder co ON s.stu_id = co.stu_id
                                INNER JOIN course c ON co.course_id = c.course_id
                                WHERE c.lec_id = ? AND c.course_id = ?";
                            $stmt_students = $conn->prepare($sql_students);
                            $stmt_students->bind_param("ii", $instructor_id, $course['course_id']);
                            $stmt_students->execute();
                            $result_students = $stmt_students->get_result();

                            while ($student = $result_students->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $student['stu_id']; ?></td>
                                    <td><?php echo $student['stu_name']; ?></td>
                                    <td><?php echo getLessonProgress($conn, $student['stu_id'], $course['course_id']); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<?php
include_once("Footer.php");

function getLessonCount($conn, $course_id)
{
    $sql = "SELECT COUNT(*) AS lesson_count FROM lesson WHERE course_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['lesson_count'];
}

function getAssessmentCount($conn, $course_id, $assessment_type)
{
    $sql = "SELECT COUNT(*) AS assessment_count FROM exam_category WHERE course_id = ? AND assessment_type = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $course_id, $assessment_type);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['assessment_count'];
}

function getStudentCount($conn, $course_id)
{
    $sql = "SELECT COUNT(*) AS student_count FROM courseorder WHERE course_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['student_count'];
}

function getLessonProgress($conn, $student_id, $course_id)
{
    $sql = "SELECT AVG(progress) AS avg_progress FROM lesson_progress WHERE student_id = ? AND course_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $student_id, $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return round($row['avg_progress'], 2);
}

function getCertifiedStudentCount($conn, $course_id)
{
    $sql = "SELECT COUNT(DISTINCT stu_id) AS certified_student_count FROM certificates WHERE course_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['certified_student_count'];
}
?>
